export default Backbone.View.extend({
    tagName:false,
    initialize: function() {
        let id = this.model.get( 'id' );
        this.$el = jQuery( '.form-content-' + id );
    },
    submit: function() {

    },
    render: function() {
        let currentStep = this.model.getCurrentStep();
        let field = currentStep;
        let fieldTmpl = CheersForms.Utils.template( 'cform-field-' + field.type );
        let stepTmpl = CheersForms.Utils.template( 'cform-step' );
        this.$el.html( fieldTmpl );
    }
});