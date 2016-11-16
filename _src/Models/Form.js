export default Backbone.Model.extend({
    defaults: {
        id: 0,
        steps: null,
        currentStep: null
    },
    initialize: function() {
    },
    validateStep: function( step, data ) {
        let steps = this.get( 'steps' );
        if ( ! steps.get( step ) ) {
            return false;
        }

        return true;
    },
    getCurrentStep: function() {
        return this.get( 'steps' )[1];
    },
    send: function() {
        alert( "SEND");
    }
});