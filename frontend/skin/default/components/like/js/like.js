
(function($) {
    "use strict";

    $.widget( "livestreet.lsLike", $.livestreet.lsComponent, {
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
            this.element.bsButton('loading');
            
            if(this.element.hasClass('active')){
                this.option('params.state', 1);
            }
            
            this._load("load", {}, function(response){
                this.option('params.state', response.state);
                this.element.button('toggle');
                this.element.bsButton('setCount', response.count);
            }.bind(this), {
                showProgress:false, 
                onComplete: function(response){
                    this.element.bsButton('loaded');
                }.bind(this)
            });
        }
        
    });
})(jQuery);