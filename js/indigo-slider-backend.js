!function ($) {
    $(document).ready(function(){

        function setTriggers(){

            var $triggers = $('.indigo-settings .trigger');

            $triggers.on('click', function(){
                $(this).closest('.indigo-settings').find("[data-parent-trigger='" + $(this).prop('id') + "']").toggle();
            });
        }

        function initialHideSettings(){
            var $settingsToHide = $('.indigo-settings .hide');

            $.each($settingsToHide, function(){
                var $input = $(this).find('input');
                if( !$('#'+ $(this).data('parent-trigger')).prop('checked') ){
                    $(this).hide();
                }
            });
        }

        // Initial Setup
        setTriggers();
        initialHideSettings();

        // When Widget is added to sidebar or saved
        $( document ).ajaxStop( function() {
            setTriggers();
            initialHideSettings();
        } );

    });
}(window.jQuery);