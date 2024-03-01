var AppSet = {
    version: "1.0",
    isDev: false,
    passPercentage: 50,
    totalQuestions: 8,
    DynamicURLEnabled: false,
    /*
        To add a new template declare a new unique key as following:
        Template_Key: {
            templateID: "A UNIQUE ID FOR THE TEMPLATE",
            pageName: "NAME OF THE HTML PAGE THAT THE TEMPLATE USES",
            controller: NAME OF THE CONTROLLER OBJECT (DEFINED IN THE TEMPLATE's JS FILE),
            bgClassName: "NAME OF THE BACKGROUND CLASS"
        }
    */
    templates: {
        
    },
    getTemplates: function () {
        var _this = this;
        var temps = {};
        var keys = Object.keys(_this.templates);
        for (var i = 0; i < keys.length; i++) {
            temps[keys[i]] = _this.templates[keys[i]].templateID;
        }
        return temps;
    },
    getTemplateClasses: function () {
        var _this = this;
        var keys = Object.keys(_this.templates);
        var classes = [];
        for (var i = 0; i < keys.length; i++) {
            if (_this.templates[keys[i]].bgClassName != "" && classes.indexOf(_this.templates[keys[i]].bgClassName) == -1)
                classes.push(_this.templates[keys[i]].bgClassName);
        }
        return classes;
    },
    getTemplateByName: function (templateID) {
        var template = {};
        var _this = this;
        var keys = Object.keys(_this.templates);
        for (var i = 0; i < keys.length; i++) {
            if (_this.templates[keys[i]].templateID == templateID) {
                template = _this.templates[keys[i]];
                break;
            }
        }
        if ($.isEmptyObject(template)) {
            console.error("No template found against template ID: " + templateID);
        }
        return template;
    },
    pages: {
        Topic: "topic_page",
        Entry: "entry_page",
        CoreGame: "game_page"
    },
};