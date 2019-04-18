
(function($) {
    "use strict";

    $.widget( "livestreet.moderationEntity", $.livestreet.lsComponent, {
        /**
         * Дефолтные опции
         */
        options: {
            // Селекторы
            
            i18n: {
                
            },
            urls:{
                load: aRouter.like + 'ajax-like'
            }
        },

        /**
         * Конструктор
         *
         * @constructor
         * @private
         */
        _create: function () {

            this._super();
            
            this._on(this.element, {click: "onClick"})

            
        },
        onClick:function(){
           
        }
        
    });
})(jQuery);