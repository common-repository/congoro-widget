//=================================
//generate sample widget
//=================================
function congoroWidget_generateWidgetSample(mainElement) {
    var l = mainElement.find('input[name="itemsCount"]:checked').val();

    var fn = mainElement.find('select[name="fontFamily"]').val();

    var fs = mainElement.find('input[name="fontSize"]').val();
    //console.log('fontSize: ' + fs);

    var rt = mainElement.find('input[name="imageType"]:checked').val();

    //console.log('imageType: ' + rt);

    var tt = mainElement.find('input[name="widgetTitle"]:checked').val();
    //console.log('widgetTitle: ' + tt);

    var widgetType = parseInt(mainElement.find('input[name="widgetType"]:checked').val()) || 0;
    var colorSet = mainElement.find('.colorsetSelect').val() || '';
    var widgetPosition = mainElement.find('.widgetPositionSelect').val() || '';


    if (widgetType === 1) {
        mainElement.find('.image-type-option').fadeOut();
    } else {
        mainElement.find('.image-type-option').fadeIn();
    }

    //disable some items when selected widget type is fixed
    if (widgetType === 2) {
        mainElement.find('.recom-length, .widget-title, .widget-position-type').hide(0);
        mainElement.find('.colorset').show(0);

        mainElement.find(".colorsetSelect").msDropDown({
            visibleRows: 5,
            height:70,
            openDirection: 'alwaysUp'
        });
    } else {
        mainElement.find('.recom-length, .widget-title, .widget-position-type').show(0);
        mainElement.find('.colorset').hide(0);
    }

    //=====================================
    // drop-down for font select
    //=====================================
    mainElement.find(".font-family-select").msDropDown({
        visibleRows: 7,
        openDirection: 'alwaysDown'
    });

    mainElement.find("textarea[name='congoro_widget_code']").text("<script data-cfasync=\"false\" src=\"http://widget.congoro.com/widget/script?l=" + l + "&fn=" + fn + "&fs=" + fs + "&rt=" + rt + "&tt=" + tt +"&cs=" + colorSet + "&wp=" + widgetPosition + "&wt=" + widgetType + "\"></scri" + "pt>");
}

function congoroWidget_showTip(tipid, element) {
    switch (tipid) {
        case false: {
            jQuery(element).parent().parent().parent().children('.add-widget-tip').hide();
            jQuery(element).parent().parent().parent().children('.after-paragraph-tip').hide();
        }
            break;
        case 'after-paragraph': {
            jQuery(element).parent().parent().parent().children('.add-widget-tip').hide();
            jQuery(element).parent().parent().parent().children('.after-paragraph-tip').fadeIn(300);
        }
            break;
        case 'widget': {
            jQuery(element).parent().parent().parent().children('.add-widget-tip').fadeIn(300);
            jQuery(element).parent().parent().parent().children('.after-paragraph-tip').hide();
        }
            break;
    }
}

function congoroWidget_makeid() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 30; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}


jQuery(document).ready(function ($) {
    var clonedWidgetContainer = $(".widget-configuration:first-child").clone();

    //initialize
    $('.widget-configuration').each(function () {
        congoroWidget_generateWidgetSample($(this));
    });

    //==================================
    //Circular loader
    //==================================
    var contentLoader = {
        show: function () {
            $('.content-loader').show();
        },
        hide: function () {
            $('.content-loader').hide();
        }
    };

    contentLoader.hide();

    //==================================
    //Font size range change
    //==================================
    $(document).on('input', '.congoro-widget-container .font-size-range', function (e) {

        var newValue = parseInt($(this).val());
        var target = $(this).prev('.font-size-range-value');
        target.html(newValue + " px");
        target.css({'font-size': (newValue + 3) + "px"})
    });

    //===================================
    //Clone widget
    //===================================
    $('.congoro-widget-container  .clone-widget-container').on('click', function (e) {
        e.preventDefault();

        clonedWidgetContainer.appendTo(".widget-configuration-container");

        var widgetNumber = $('.widget-configuration').length;

        $('.widget-configuration:last-child .widget-first-title').html('ویجت ' + widgetNumber);
        $('.widget-configuration:last-child .widgetId').val(congoroWidget_makeid());

        //scroll to new cloned widget-configuration
        var target = $('.widget-configuration:last-child');
        $('html, body').animate({
            scrollTop: target.offset().top - 20
        }, 400);

        congoroWidget_generateWidgetSample(target);
        contentLoader.hide();
    });

    //======================================
    //Remove widget
    //======================================
    $(document).on('click', '.congoro-widget-container  .remove-widget', function (e) {
        if ($('.widget-configuration').length === 1) {
            alert('در صورتی که فقط یک ویجت فعال دارید حذف آن ممکن نیست.');
            return false;
        }

        var that = this;
        $(that).closest('.widget-configuration').css('background-color', 'rgba(255, 0, 0, 0.14)').fadeOut(300, function () {
            $(that).closest('.widget-configuration').remove();

            var widgetId = $(that).closest('.widget-configuration').find('.widgetId').val();
            $.ajax({
                url: 'options-general.php?page=congoro.php',
                method: 'POST',
                data: {remove_widget: true, widgetId: widgetId},
                success: function (res) {

                },
                error: function () {
                }
            });

            //reorder widget names
            var widgetNumber = 1;
            $('.widget-configuration').each(function (e) {
                $(this).find('.widget-first-title').html('ویجت ' + widgetNumber++);
            });
        });
    });

    //=====================================
    //Save widget
    //=====================================
    $(document).on('submit', '.congoro-widget-container .widget-form', function (e) {
        e.preventDefault();
        contentLoader.show();

        //regenerate form before submit
        congoroWidget_generateWidgetSample($(this));

        var that = this;

        setTimeout(function () {
            $.ajax({
                url: $(that).attr('action'),
                method: 'POST',
                cache: false,
                data: $(that).serialize(),
                success: function (res) {
                    contentLoader.hide();
                },
                error: function () {
                    contentLoader.hide();
                }
            });
        },100);
    });

});