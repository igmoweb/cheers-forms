(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = Backbone.Collection.extend({});

},{}],2:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});
exports.default = Backbone.Model.extend({
    defaults: {
        id: 0,
        steps: null,
        currentStep: null
    },
    initialize: function initialize() {},
    validateStep: function validateStep(step, data) {
        var steps = this.get('steps');
        if (!steps.get(step)) {
            return false;
        }

        return true;
    },
    getCurrentStep: function getCurrentStep() {
        return this.get('steps')[1];
    },
    send: function send() {
        alert("SEND");
    }
});

},{}],3:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = Backbone.Model.extend({});

},{}],4:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = Backbone.Model.extend({});

},{}],5:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});
exports.default = Backbone.View.extend({
    tagName: false,
    initialize: function initialize() {
        var id = this.model.get('id');
        this.$el = jQuery('.form-content-' + id);
    },
    submit: function submit() {},
    render: function render() {
        var currentStep = this.model.getCurrentStep();
        var field = currentStep;
        var fieldTmpl = CheersForms.Utils.template('cform-field-' + field.type);
        var stepTmpl = CheersForms.Utils.template('cform-step');
        this.$el.html(fieldTmpl);
    }
});

},{}],6:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = Backbone.View.extend({});

},{}],7:[function(require,module,exports){
'use strict';

var _Form = require('./Models/Form');

var _Form2 = _interopRequireDefault(_Form);

var _FormField = require('./Models/FormField');

var _FormField2 = _interopRequireDefault(_FormField);

var _FormStep = require('./Models/FormStep');

var _FormStep2 = _interopRequireDefault(_FormStep);

var _Form3 = require('./Views/Form');

var _Form4 = _interopRequireDefault(_Form3);

var _FormField3 = require('./Views/FormField');

var _FormField4 = _interopRequireDefault(_FormField3);

var _FormSteps = require('./Collections/FormSteps');

var _FormSteps2 = _interopRequireDefault(_FormSteps);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

//import FormStepFieldsCollection from './Collections/FormStepFields'

// Views
window.CheersForms = {
    Models: {
        Form: _Form2.default,
        FormStep: _FormStep2.default,
        FormField: _FormField2.default
    },
    Views: {
        FormView: _Form4.default,
        FormStepView: _Form4.default,
        FormFieldView: _FormField4.default
    },
    Collections: {
        FormStepsCollection: _FormSteps2.default
    }
};

// Collections
// Models


window.CheersForms.Utils = {};

window.CheersForms.Utils.initForm = function (form) {
    var Form = new CheersForms.Models.Form(form);
    var View = new CheersForms.Views.FormView({ model: Form });
    View.render();
    return View;
};

window.CheersForms.Utils.template = _.memoize(function (id) {
    var compiled,

    /*
     * Underscore's default ERB-style templates are incompatible with PHP
     * when asp_tags is enabled, so WordPress uses Mustache-inspired templating syntax.
     *
     * @see trac ticket #22344.
     */
    options = {
        evaluate: /<#([\s\S]+?)#>/g,
        interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
        escape: /\{\{([^\}]+?)\}\}(?!\})/g,
        variable: 'data'
    };

    return function (data) {
        compiled = compiled || _.template(jQuery('#tmpl-' + id).html(), options);
        return compiled(data);
    };
});

},{"./Collections/FormSteps":1,"./Models/Form":2,"./Models/FormField":3,"./Models/FormStep":4,"./Views/Form":5,"./Views/FormField":6}]},{},[7])
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9icm93c2VyaWZ5L25vZGVfbW9kdWxlcy9icm93c2VyLXBhY2svX3ByZWx1ZGUuanMiLCJfc3JjL0NvbGxlY3Rpb25zL0Zvcm1TdGVwcy5qcyIsIl9zcmMvTW9kZWxzL0Zvcm0uanMiLCJfc3JjL01vZGVscy9Gb3JtRmllbGQuanMiLCJfc3JjL01vZGVscy9Gb3JtU3RlcC5qcyIsIl9zcmMvVmlld3MvRm9ybS5qcyIsIl9zcmMvVmlld3MvRm9ybUZpZWxkLmpzIiwiX3NyYy9jZm9ybXMuanMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBQUE7Ozs7OztrQkNBZSxTQUFTLFVBQVQsQ0FBb0IsTUFBcEIsQ0FBMkIsRUFBM0IsQzs7Ozs7Ozs7a0JDQUEsU0FBUyxLQUFULENBQWUsTUFBZixDQUFzQjtBQUNqQyxjQUFVO0FBQ04sWUFBSSxDQURFO0FBRU4sZUFBTyxJQUZEO0FBR04scUJBQWE7QUFIUCxLQUR1QjtBQU1qQyxnQkFBWSxzQkFBVyxDQUN0QixDQVBnQztBQVFqQyxrQkFBYyxzQkFBVSxJQUFWLEVBQWdCLElBQWhCLEVBQXVCO0FBQ2pDLFlBQUksUUFBUSxLQUFLLEdBQUwsQ0FBVSxPQUFWLENBQVo7QUFDQSxZQUFLLENBQUUsTUFBTSxHQUFOLENBQVcsSUFBWCxDQUFQLEVBQTJCO0FBQ3ZCLG1CQUFPLEtBQVA7QUFDSDs7QUFFRCxlQUFPLElBQVA7QUFDSCxLQWZnQztBQWdCakMsb0JBQWdCLDBCQUFXO0FBQ3ZCLGVBQU8sS0FBSyxHQUFMLENBQVUsT0FBVixFQUFvQixDQUFwQixDQUFQO0FBQ0gsS0FsQmdDO0FBbUJqQyxVQUFNLGdCQUFXO0FBQ2IsY0FBTyxNQUFQO0FBQ0g7QUFyQmdDLENBQXRCLEM7Ozs7Ozs7O2tCQ0FBLFNBQVMsS0FBVCxDQUFlLE1BQWYsQ0FBc0IsRUFBdEIsQzs7Ozs7Ozs7a0JDQUEsU0FBUyxLQUFULENBQWUsTUFBZixDQUFzQixFQUF0QixDOzs7Ozs7OztrQkNBQSxTQUFTLElBQVQsQ0FBYyxNQUFkLENBQXFCO0FBQ2hDLGFBQVEsS0FEd0I7QUFFaEMsZ0JBQVksc0JBQVc7QUFDbkIsWUFBSSxLQUFLLEtBQUssS0FBTCxDQUFXLEdBQVgsQ0FBZ0IsSUFBaEIsQ0FBVDtBQUNBLGFBQUssR0FBTCxHQUFXLE9BQVEsbUJBQW1CLEVBQTNCLENBQVg7QUFDSCxLQUwrQjtBQU1oQyxZQUFRLGtCQUFXLENBRWxCLENBUitCO0FBU2hDLFlBQVEsa0JBQVc7QUFDZixZQUFJLGNBQWMsS0FBSyxLQUFMLENBQVcsY0FBWCxFQUFsQjtBQUNBLFlBQUksUUFBUSxXQUFaO0FBQ0EsWUFBSSxZQUFZLFlBQVksS0FBWixDQUFrQixRQUFsQixDQUE0QixpQkFBaUIsTUFBTSxJQUFuRCxDQUFoQjtBQUNBLFlBQUksV0FBVyxZQUFZLEtBQVosQ0FBa0IsUUFBbEIsQ0FBNEIsWUFBNUIsQ0FBZjtBQUNBLGFBQUssR0FBTCxDQUFTLElBQVQsQ0FBZSxTQUFmO0FBQ0g7QUFmK0IsQ0FBckIsQzs7Ozs7Ozs7a0JDQUEsU0FBUyxJQUFULENBQWMsTUFBZCxDQUFxQixFQUFyQixDOzs7OztBQ0NmOzs7O0FBQ0E7Ozs7QUFDQTs7OztBQUdBOzs7O0FBRUE7Ozs7QUFHQTs7Ozs7O0FBQ0E7O0FBUEE7QUFTQSxPQUFPLFdBQVAsR0FBcUI7QUFDakIsWUFBUTtBQUNKLDRCQURJO0FBRUosb0NBRkk7QUFHSjtBQUhJLEtBRFM7QUFNakIsV0FBTztBQUNILGdDQURHO0FBRUgsb0NBRkc7QUFHSDtBQUhHLEtBTlU7QUFXakIsaUJBQWE7QUFDVDtBQURTO0FBWEksQ0FBckI7O0FBSkE7QUFWQTs7O0FBK0JBLE9BQU8sV0FBUCxDQUFtQixLQUFuQixHQUEyQixFQUEzQjs7QUFFQSxPQUFPLFdBQVAsQ0FBbUIsS0FBbkIsQ0FBeUIsUUFBekIsR0FBb0MsVUFBVSxJQUFWLEVBQWlCO0FBQ2pELFFBQUksT0FBTyxJQUFJLFlBQVksTUFBWixDQUFtQixJQUF2QixDQUE0QixJQUE1QixDQUFYO0FBQ0EsUUFBSSxPQUFPLElBQUksWUFBWSxLQUFaLENBQWtCLFFBQXRCLENBQStCLEVBQUUsT0FBTyxJQUFULEVBQS9CLENBQVg7QUFDQSxTQUFLLE1BQUw7QUFDQSxXQUFPLElBQVA7QUFDSCxDQUxEOztBQU9BLE9BQU8sV0FBUCxDQUFtQixLQUFuQixDQUF5QixRQUF6QixHQUFvQyxFQUFFLE9BQUYsQ0FBVSxVQUFXLEVBQVgsRUFBZ0I7QUFDMUQsUUFBSSxRQUFKOztBQUNJOzs7Ozs7QUFNQSxjQUFVO0FBQ04sa0JBQWEsaUJBRFA7QUFFTixxQkFBYSx5QkFGUDtBQUdOLGdCQUFhLDBCQUhQO0FBSU4sa0JBQWE7QUFKUCxLQVBkOztBQWNBLFdBQU8sVUFBVyxJQUFYLEVBQWtCO0FBQ3JCLG1CQUFXLFlBQVksRUFBRSxRQUFGLENBQVksT0FBUSxXQUFXLEVBQW5CLEVBQXdCLElBQXhCLEVBQVosRUFBNkMsT0FBN0MsQ0FBdkI7QUFDQSxlQUFPLFNBQVUsSUFBVixDQUFQO0FBQ0gsS0FIRDtBQUlILENBbkJtQyxDQUFwQyIsImZpbGUiOiJnZW5lcmF0ZWQuanMiLCJzb3VyY2VSb290IjoiIiwic291cmNlc0NvbnRlbnQiOlsiKGZ1bmN0aW9uIGUodCxuLHIpe2Z1bmN0aW9uIHMobyx1KXtpZighbltvXSl7aWYoIXRbb10pe3ZhciBhPXR5cGVvZiByZXF1aXJlPT1cImZ1bmN0aW9uXCImJnJlcXVpcmU7aWYoIXUmJmEpcmV0dXJuIGEobywhMCk7aWYoaSlyZXR1cm4gaShvLCEwKTt2YXIgZj1uZXcgRXJyb3IoXCJDYW5ub3QgZmluZCBtb2R1bGUgJ1wiK28rXCInXCIpO3Rocm93IGYuY29kZT1cIk1PRFVMRV9OT1RfRk9VTkRcIixmfXZhciBsPW5bb109e2V4cG9ydHM6e319O3Rbb11bMF0uY2FsbChsLmV4cG9ydHMsZnVuY3Rpb24oZSl7dmFyIG49dFtvXVsxXVtlXTtyZXR1cm4gcyhuP246ZSl9LGwsbC5leHBvcnRzLGUsdCxuLHIpfXJldHVybiBuW29dLmV4cG9ydHN9dmFyIGk9dHlwZW9mIHJlcXVpcmU9PVwiZnVuY3Rpb25cIiYmcmVxdWlyZTtmb3IodmFyIG89MDtvPHIubGVuZ3RoO28rKylzKHJbb10pO3JldHVybiBzfSkiLCJleHBvcnQgZGVmYXVsdCBCYWNrYm9uZS5Db2xsZWN0aW9uLmV4dGVuZCh7fSk7XG4iLCJleHBvcnQgZGVmYXVsdCBCYWNrYm9uZS5Nb2RlbC5leHRlbmQoe1xuICAgIGRlZmF1bHRzOiB7XG4gICAgICAgIGlkOiAwLFxuICAgICAgICBzdGVwczogbnVsbCxcbiAgICAgICAgY3VycmVudFN0ZXA6IG51bGxcbiAgICB9LFxuICAgIGluaXRpYWxpemU6IGZ1bmN0aW9uKCkge1xuICAgIH0sXG4gICAgdmFsaWRhdGVTdGVwOiBmdW5jdGlvbiggc3RlcCwgZGF0YSApIHtcbiAgICAgICAgbGV0IHN0ZXBzID0gdGhpcy5nZXQoICdzdGVwcycgKTtcbiAgICAgICAgaWYgKCAhIHN0ZXBzLmdldCggc3RlcCApICkge1xuICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgICAgICB9XG5cbiAgICAgICAgcmV0dXJuIHRydWU7XG4gICAgfSxcbiAgICBnZXRDdXJyZW50U3RlcDogZnVuY3Rpb24oKSB7XG4gICAgICAgIHJldHVybiB0aGlzLmdldCggJ3N0ZXBzJyApWzFdO1xuICAgIH0sXG4gICAgc2VuZDogZnVuY3Rpb24oKSB7XG4gICAgICAgIGFsZXJ0KCBcIlNFTkRcIik7XG4gICAgfVxufSk7IiwiZXhwb3J0IGRlZmF1bHQgQmFja2JvbmUuTW9kZWwuZXh0ZW5kKHt9KTtcbiIsImV4cG9ydCBkZWZhdWx0IEJhY2tib25lLk1vZGVsLmV4dGVuZCh7fSk7IiwiZXhwb3J0IGRlZmF1bHQgQmFja2JvbmUuVmlldy5leHRlbmQoe1xuICAgIHRhZ05hbWU6ZmFsc2UsXG4gICAgaW5pdGlhbGl6ZTogZnVuY3Rpb24oKSB7XG4gICAgICAgIGxldCBpZCA9IHRoaXMubW9kZWwuZ2V0KCAnaWQnICk7XG4gICAgICAgIHRoaXMuJGVsID0galF1ZXJ5KCAnLmZvcm0tY29udGVudC0nICsgaWQgKTtcbiAgICB9LFxuICAgIHN1Ym1pdDogZnVuY3Rpb24oKSB7XG5cbiAgICB9LFxuICAgIHJlbmRlcjogZnVuY3Rpb24oKSB7XG4gICAgICAgIGxldCBjdXJyZW50U3RlcCA9IHRoaXMubW9kZWwuZ2V0Q3VycmVudFN0ZXAoKTtcbiAgICAgICAgbGV0IGZpZWxkID0gY3VycmVudFN0ZXA7XG4gICAgICAgIGxldCBmaWVsZFRtcGwgPSBDaGVlcnNGb3Jtcy5VdGlscy50ZW1wbGF0ZSggJ2Nmb3JtLWZpZWxkLScgKyBmaWVsZC50eXBlICk7XG4gICAgICAgIGxldCBzdGVwVG1wbCA9IENoZWVyc0Zvcm1zLlV0aWxzLnRlbXBsYXRlKCAnY2Zvcm0tc3RlcCcgKTtcbiAgICAgICAgdGhpcy4kZWwuaHRtbCggZmllbGRUbXBsICk7XG4gICAgfVxufSk7IiwiZXhwb3J0IGRlZmF1bHQgQmFja2JvbmUuVmlldy5leHRlbmQoe1xuXG59KTtcbiIsIi8vIE1vZGVsc1xuaW1wb3J0IEZvcm0gZnJvbSAnLi9Nb2RlbHMvRm9ybSc7XG5pbXBvcnQgRm9ybUZpZWxkIGZyb20gJy4vTW9kZWxzL0Zvcm1GaWVsZCc7XG5pbXBvcnQgRm9ybVN0ZXAgZnJvbSAnLi9Nb2RlbHMvRm9ybVN0ZXAnO1xuXG4vLyBWaWV3c1xuaW1wb3J0IEZvcm1WaWV3IGZyb20gJy4vVmlld3MvRm9ybSc7XG5pbXBvcnQgRm9ybVN0ZXBWaWV3IGZyb20gJy4vVmlld3MvRm9ybSc7XG5pbXBvcnQgRm9ybUZpZWxkVmlldyBmcm9tICcuL1ZpZXdzL0Zvcm1GaWVsZCc7XG5cbi8vIENvbGxlY3Rpb25zXG5pbXBvcnQgRm9ybVN0ZXBzQ29sbGVjdGlvbiBmcm9tICcuL0NvbGxlY3Rpb25zL0Zvcm1TdGVwcydcbi8vaW1wb3J0IEZvcm1TdGVwRmllbGRzQ29sbGVjdGlvbiBmcm9tICcuL0NvbGxlY3Rpb25zL0Zvcm1TdGVwRmllbGRzJ1xuXG53aW5kb3cuQ2hlZXJzRm9ybXMgPSB7XG4gICAgTW9kZWxzOiB7XG4gICAgICAgIEZvcm06IEZvcm0sXG4gICAgICAgIEZvcm1TdGVwOiBGb3JtU3RlcCxcbiAgICAgICAgRm9ybUZpZWxkOiBGb3JtRmllbGRcbiAgICB9LFxuICAgIFZpZXdzOiB7XG4gICAgICAgIEZvcm1WaWV3OiBGb3JtVmlldyxcbiAgICAgICAgRm9ybVN0ZXBWaWV3OiBGb3JtU3RlcFZpZXcsXG4gICAgICAgIEZvcm1GaWVsZFZpZXc6IEZvcm1GaWVsZFZpZXdcbiAgICB9LFxuICAgIENvbGxlY3Rpb25zOiB7XG4gICAgICAgIEZvcm1TdGVwc0NvbGxlY3Rpb246IEZvcm1TdGVwc0NvbGxlY3Rpb25cbiAgICB9XG59O1xuXG5cbndpbmRvdy5DaGVlcnNGb3Jtcy5VdGlscyA9IHt9O1xuXG53aW5kb3cuQ2hlZXJzRm9ybXMuVXRpbHMuaW5pdEZvcm0gPSBmdW5jdGlvbiggZm9ybSApIHtcbiAgICBsZXQgRm9ybSA9IG5ldyBDaGVlcnNGb3Jtcy5Nb2RlbHMuRm9ybShmb3JtKTtcbiAgICBsZXQgVmlldyA9IG5ldyBDaGVlcnNGb3Jtcy5WaWV3cy5Gb3JtVmlldyh7IG1vZGVsOiBGb3JtIH0pO1xuICAgIFZpZXcucmVuZGVyKCk7XG4gICAgcmV0dXJuIFZpZXc7XG59O1xuXG53aW5kb3cuQ2hlZXJzRm9ybXMuVXRpbHMudGVtcGxhdGUgPSBfLm1lbW9pemUoZnVuY3Rpb24gKCBpZCApIHtcbiAgICB2YXIgY29tcGlsZWQsXG4gICAgICAgIC8qXG4gICAgICAgICAqIFVuZGVyc2NvcmUncyBkZWZhdWx0IEVSQi1zdHlsZSB0ZW1wbGF0ZXMgYXJlIGluY29tcGF0aWJsZSB3aXRoIFBIUFxuICAgICAgICAgKiB3aGVuIGFzcF90YWdzIGlzIGVuYWJsZWQsIHNvIFdvcmRQcmVzcyB1c2VzIE11c3RhY2hlLWluc3BpcmVkIHRlbXBsYXRpbmcgc3ludGF4LlxuICAgICAgICAgKlxuICAgICAgICAgKiBAc2VlIHRyYWMgdGlja2V0ICMyMjM0NC5cbiAgICAgICAgICovXG4gICAgICAgIG9wdGlvbnMgPSB7XG4gICAgICAgICAgICBldmFsdWF0ZTogICAgLzwjKFtcXHNcXFNdKz8pIz4vZyxcbiAgICAgICAgICAgIGludGVycG9sYXRlOiAvXFx7XFx7XFx7KFtcXHNcXFNdKz8pXFx9XFx9XFx9L2csXG4gICAgICAgICAgICBlc2NhcGU6ICAgICAgL1xce1xceyhbXlxcfV0rPylcXH1cXH0oPyFcXH0pL2csXG4gICAgICAgICAgICB2YXJpYWJsZTogICAgJ2RhdGEnXG4gICAgICAgIH07XG5cbiAgICByZXR1cm4gZnVuY3Rpb24gKCBkYXRhICkge1xuICAgICAgICBjb21waWxlZCA9IGNvbXBpbGVkIHx8IF8udGVtcGxhdGUoIGpRdWVyeSggJyN0bXBsLScgKyBpZCApLmh0bWwoKSwgIG9wdGlvbnMgKTtcbiAgICAgICAgcmV0dXJuIGNvbXBpbGVkKCBkYXRhICk7XG4gICAgfTtcbn0pOyJdfQ==
