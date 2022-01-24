// jQuery
$(function () {

				// Смена Местоположения
				$('html').on('change', '.AMGdivselect select', function () {

								var elem = $(this);

								// Меняем значение inputa
								$(elem).closest('tr').find('input').val($(this).val());
								// Удаляем все нижележачие select-ы
								$(this).nextAll().remove();
								// Обновляем select-ы
								$.post("/bitrix/components/bendersay.main/ajax/ajax.php", {
												Location_ID: $(this).val()
								}).done(function (data) {

												elem.after(data);

								})
								.fail(function () {
												alert('error');
								});

				});

				// Удаление местоположения
				$('html').on('click', '.AMGdelblock', function () {

								var elem = $(this);

								// Удаляем пустые td
								$(elem.closest('tbody').find('td')).each(function () {
												if ($.trim($(this).html()) == "") {
																$(this).parent().remove();
												}
								});
								console.log(elem.prev().val());
								elem.prev().val('');
								console.log(elem.prev().val());

								if (elem.closest('tbody').children().length > 2) {
												elem.closest('.AMGedit_elem').slideUp(600, 'swing');
												setTimeout(function () {
																elem.closest('tr').remove();
												}, 600);
								} else {
												elem.closest('.AMGedit_elem').find('input').val('');
								}

				});

});