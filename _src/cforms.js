// Models
import Form from './Models/Form';
import FormField from './Models/FormField';
import FormStep from './Models/FormStep';

// Views
import FormView from './Views/Form';
import FormStepView from './Views/Form';
import FormFieldView from './Views/FormField';

// Collections
import FormStepsCollection from './Collections/FormSteps'
//import FormStepFieldsCollection from './Collections/FormStepFields'

window.CheersForms = {
    Models: {
        Form: Form,
        FormStep: FormStep,
        FormField: FormField
    },
    Views: {
        FormView: FormView,
        FormStepView: FormStepView,
        FormFieldView: FormFieldView
    },
    Collections: {
        FormStepsCollection: FormStepsCollection
    }
};


window.CheersForms.Utils = {};

window.CheersForms.Utils.initForm = function( form ) {
    let Form = new CheersForms.Models.Form(form);
    let View = new CheersForms.Views.FormView({ model: Form });
    View.render();
    return View;
};

window.CheersForms.Utils.template = _.memoize(function ( id ) {
    var compiled,
        /*
         * Underscore's default ERB-style templates are incompatible with PHP
         * when asp_tags is enabled, so WordPress uses Mustache-inspired templating syntax.
         *
         * @see trac ticket #22344.
         */
        options = {
            evaluate:    /<#([\s\S]+?)#>/g,
            interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
            escape:      /\{\{([^\}]+?)\}\}(?!\})/g,
            variable:    'data'
        };

    return function ( data ) {
        compiled = compiled || _.template( jQuery( '#tmpl-' + id ).html(),  options );
        return compiled( data );
    };
});