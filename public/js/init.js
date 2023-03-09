$(document).ready(function() {
    // $('.isDate:not([readonly])').datepicker({
    //     format: "dd/mm/yyyy",
    //     language: "pt-BR",
    //     todayHighlight: true,
    //     orientation: "bottom auto"
    // });

    // $(".isSelect2").select2();

    $(".isNumber").keydown(function (e) {
       if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
           (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
           (e.keyCode >= 35 && e.keyCode <= 40)) {
                return;
       }
       if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
           e.preventDefault();
       }
    });

    $('.isDate').attr('autocomplete', 'off');
    $('.isDate').mask('00/00/0000');
    $('.isDateTime').attr('autocomplete', 'off');
    $('.isDateTime').mask('00/00/0000 00:00:00');
    $('.isTime').mask('00:00:00');

    $('.isDateMonth').mask('00/0000');
    $('.isCEP').mask('00000-000');
    $('.isCPF').mask('000.000.000-00');
    $('.isCNPJ').mask('00.000.000/0000-00');
    $('.isCNS').mask('000.0000.0000.0000');
    $('.isMoney').mask('###.###.###.#00,00', {reverse: true});
    $('.isDecimal').mask('#####,000', {reverse: true});

    $('.isPeso').mask('#00,000', {reverse: true});
    $('.isAltura').mask('000');
    $('.isTemperatura').mask('00,000');
    $('.isAnoModelo').mask('00/00');
    $('.isPlaca').mask('AAA-0Z00', {

        translation: {
          'Z': {
            pattern: /[a-zA-Z0-9]/
            }
        }
      });

    /* Início - Máscara para telefone com e sem o 9 */
    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    spOptions = {
    onKeyPress: function(val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
    };
    $('.isTelefone').mask(SPMaskBehavior, spOptions);
    /* Fim - Máscara para telefone com e sem o 9 */

    var url = window.location.pathname,
    url = url.replace(/\/$/, "");
    url = decodeURIComponent(url);

    $('.sidebar-link').each(function(){
        var href = $(this).attr('href');
        if (href.includes(url.split('/')[1])) {
            $(this).parent().addClass('active');
        }
    });

    $('.submenu-item a').each(function(){
        var href = $(this).attr('href');
        if (href.includes(url.split('/')[2])) {

            $(this).parent().addClass('active');
            $(this).parent().parent().parent().addClass('active');
            $(this).parent().parent().addClass('active');
        }
    });

    $('#botao-toggle').on('click', function() {
        if ($('#sidebar').hasClass('active')) {
            $('#sidebar').removeClass('active');
        } else {
            $('#sidebar').addClass('active');
        }

        objCalendar.updateSize();
    });

    // var tooltip = new bootstrap.Tooltip(document.querySelector('.tooltip-i'), {})
});