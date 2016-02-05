!function ($) {
    $(document).ready(function(){

        function setTriggers(){
            var $triggers = $('.trigger');

            var $settingsToHide = $('.indigo-settings .hide');

            console.log($settingsToHide);

            $.each($settingsToHide, function(){
                console.log($(this).find('input').prop('checked'));


                var $input = $(this).find('input');
                if(!$('#'+ $(this).data('parent-trigger')).prop('checked')){
                    $(this).hide();
                }
            });

            $triggers.on('click', function(){
                $(this).closest('.indigo-settings').find("[data-parent-trigger='" + $(this).prop('id') + "']").toggle();
            });

        }

        setTriggers();


        // Set triggers after save
        jQuery(document).on('widget-updated', function(e, widget){
            setTriggers();
        });

    });
}(window.jQuery);