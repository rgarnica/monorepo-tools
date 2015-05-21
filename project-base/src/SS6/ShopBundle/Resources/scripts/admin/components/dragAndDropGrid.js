(function ($){

	SS6 = SS6 || {};
	SS6.dragAndDropGrid = SS6.dragAndDropGrid || {};

	SS6.dragAndDropGrid.init = function () {
		$('.js-drag-and-drop-grid-rows').sortable({
			create: SS6.dragAndDropGrid.onCreate,
			cursor: 'move',
			handle: '.cursor-move',
			items: '.js-grid-row',
			placeholder: 'table-drop',
			revert: 200,
			update: SS6.dragAndDropGrid.onUpdate
		});

		$('.js-grid').each(function () {
			var $grid = $(this);
			SS6.dragAndDropGrid.initGrid($grid);
		});
	};

	SS6.dragAndDropGrid.initGrid = function ($grid) {
		$grid.find('.js-drag-and-drop-grid-submit').click(function () {
			if (!$grid.data('positionsChanged')) {
				return false;
			}

			SS6.dragAndDropGrid.saveOrdering($grid);
		});

		$grid.data('positionsChanged', false);
		SS6.dragAndDropGrid.highlightChanges($grid, false);
	};

	SS6.dragAndDropGrid.getPositions = function ($grid) {
		var rows = $grid.find('.js-grid-row');

		var rowIds = [];
		$.each(rows, function(index, row) {
			rowIds.push($(row).data('drag-and-drop-grid-row-id'));
		});

		return rowIds;
	};

	SS6.dragAndDropGrid.saveOrdering = function ($grid, rowIds) {
		var data = {
			entityClass: $grid.data('drag-and-drop-ordering-entity-class'),
			rowIds: SS6.dragAndDropGrid.getPositions($grid)
		};

		$.ajax({
			url: $grid.data('drag-and-drop-url-save-ordering'),
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function () {
				$grid.data('positionsChanged', false);
				SS6.dragAndDropGrid.highlightChanges($grid, false);

				SS6.window({content: 'Pořadí bylo uloženo'});
			},
			error: function () {
				SS6.window({content: 'Pořadí se nepodařilo uložit'});
			}
		});
		$grid.trigger('save');
	};

	SS6.dragAndDropGrid.onUpdate = function (event, ui) {
		var $grid = $(event.target).closest('.js-grid');

		$grid.data('positionsChanged', true);
		SS6.dragAndDropGrid.highlightChanges($grid, true);
		$grid.trigger('update');
	};

	SS6.dragAndDropGrid.highlightChanges = function ($grid, highlight) {
		if (highlight) {
			$grid.find('.js-drag-and-drop-grid-submit').removeClass('btn-disabled');
		} else {
			$grid.find('.js-drag-and-drop-grid-submit').addClass('btn-disabled');
		}
	};

	$(document).ready(function () {
		SS6.dragAndDropGrid.init();
	});

})(jQuery);
