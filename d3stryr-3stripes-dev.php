<html>
  <head>
  <meta charset="UTF-8">
  <?php
    $debug=False;
    set_time_limit(0);
    $actionURL="/d3stryr-3stripes-dev.php";
  ?>
  <title>d3stryr 3stripes</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script>
    /* Notify.js - http://notifyjs.com/ Copyright (c) 2015 MIT */
    (function (factory) {
      // UMD start
      // https://github.com/umdjs/umd/blob/master/jqueryPluginCommonjs.js
      if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
      } else if (typeof module === 'object' && module.exports) {
        // Node/CommonJS
        module.exports = function( root, jQuery ) {
          if ( jQuery === undefined ) {
            // require('jQuery') returns a factory that requires window to
            // build a jQuery instance, we normalize how we use modules
            // that require this pattern but the window provided is a noop
            // if it's defined (how jquery works)
            if ( typeof window !== 'undefined' ) {
              jQuery = require('jquery');
            }
            else {
              jQuery = require('jquery')(root);
            }
          }
          factory(jQuery);
          return jQuery;
        };
      } else {
        // Browser globals
        factory(jQuery);
      }
    }(function ($) {
      //IE8 indexOf polyfill
      var indexOf = [].indexOf || function(item) {
        for (var i = 0, l = this.length; i < l; i++) {
          if (i in this && this[i] === item) {
            return i;
          }
        }
        return -1;
      };

      var pluginName = "notify";
      var pluginClassName = pluginName + "js";
      var blankFieldName = pluginName + "!blank";

      var positions = {
        t: "top",
        m: "middle",
        b: "bottom",
        l: "left",
        c: "center",
        r: "right"
      };
      var hAligns = ["l", "c", "r"];
      var vAligns = ["t", "m", "b"];
      var mainPositions = ["t", "b", "l", "r"];
      var opposites = {
        t: "b",
        m: null,
        b: "t",
        l: "r",
        c: null,
        r: "l"
      };

      var parsePosition = function(str) {
        var pos;
        pos = [];
        $.each(str.split(/\W+/), function(i, word) {
          var w;
          w = word.toLowerCase().charAt(0);
          if (positions[w]) {
            return pos.push(w);
          }
        });
        return pos;
      };

      var styles = {};

      var coreStyle = {
        name: "core",
        html: "<div class=\"" + pluginClassName + "-wrapper\">\n  <div class=\"" + pluginClassName + "-arrow\"></div>\n <div class=\"" + pluginClassName + "-container\"></div>\n</div>",
        css: "." + pluginClassName + "-corner {\n position: fixed;\n  margin: 5px;\n  z-index: 1050;\n}\n\n." + pluginClassName + "-corner ." + pluginClassName + "-wrapper,\n." + pluginClassName + "-corner ." + pluginClassName + "-container {\n  position: relative;\n display: block;\n height: inherit;\n  width: inherit;\n margin: 3px;\n}\n\n." + pluginClassName + "-wrapper {\n z-index: 1;\n position: absolute;\n display: inline-block;\n  height: 0;\n  width: 0;\n}\n\n." + pluginClassName + "-container {\n  display: none;\n  z-index: 1;\n position: absolute;\n}\n\n." + pluginClassName + "-hidable {\n  cursor: pointer;\n}\n\n[data-notify-text],[data-notify-html] {\n  position: relative;\n}\n\n." + pluginClassName + "-arrow {\n  position: absolute;\n z-index: 2;\n width: 0;\n height: 0;\n}"
      };

      var stylePrefixes = {
        "border-radius": ["-webkit-", "-moz-"]
      };

      var getStyle = function(name) {
        return styles[name];
      };

      var removeStyle = function(name) {
        if (!name) {
          throw "Missing Style name";
        }
        if (styles[name]) {
          delete styles[name];
        }
      };

      var addStyle = function(name, def) {
        if (!name) {
          throw "Missing Style name";
        }
        if (!def) {
          throw "Missing Style definition";
        }
        if (!def.html) {
          throw "Missing Style HTML";
        }
        //remove existing style
        var existing = styles[name];
        if (existing && existing.cssElem) {
          if (window.console) {
            console.warn(pluginName + ": overwriting style '" + name + "'");
          }
          styles[name].cssElem.remove();
        }
        def.name = name;
        styles[name] = def;
        var cssText = "";
        if (def.classes) {
          $.each(def.classes, function(className, props) {
            cssText += "." + pluginClassName + "-" + def.name + "-" + className + " {\n";
            $.each(props, function(name, val) {
              if (stylePrefixes[name]) {
                $.each(stylePrefixes[name], function(i, prefix) {
                  return cssText += " " + prefix + name + ": " + val + ";\n";
                });
              }
              return cssText += " " + name + ": " + val + ";\n";
            });
            return cssText += "}\n";
          });
        }
        if (def.css) {
          cssText += "/* styles for " + def.name + " */\n" + def.css;
        }
        if (cssText) {
          def.cssElem = insertCSS(cssText);
          def.cssElem.attr("id", "notify-" + def.name);
        }
        var fields = {};
        var elem = $(def.html);
        findFields("html", elem, fields);
        findFields("text", elem, fields);
        def.fields = fields;
      };

      var insertCSS = function(cssText) {
        var e, elem, error;
        elem = createElem("style");
        elem.attr("type", 'text/css');
        $("head").append(elem);
        try {
          elem.html(cssText);
        } catch (_) {
          elem[0].styleSheet.cssText = cssText;
        }
        return elem;
      };

      var findFields = function(type, elem, fields) {
        var attr;
        if (type !== "html") {
          type = "text";
        }
        attr = "data-notify-" + type;
        return find(elem, "[" + attr + "]").each(function() {
          var name;
          name = $(this).attr(attr);
          if (!name) {
            name = blankFieldName;
          }
          fields[name] = type;
        });
      };

      var find = function(elem, selector) {
        if (elem.is(selector)) {
          return elem;
        } else {
          return elem.find(selector);
        }
      };

      var pluginOptions = {
        clickToHide: true,
        autoHide: true,
        autoHideDelay: 5000,
        arrowShow: true,
        arrowSize: 5,
        breakNewLines: true,
        elementPosition: "bottom",
        globalPosition: "top right",
        style: "bootstrap",
        className: "error",
        showAnimation: "slideDown",
        showDuration: 400,
        hideAnimation: "slideUp",
        hideDuration: 200,
        gap: 5
      };

      var inherit = function(a, b) {
        var F;
        F = function() {};
        F.prototype = a;
        return $.extend(true, new F(), b);
      };

      var defaults = function(opts) {
        return $.extend(pluginOptions, opts);
      };

      var createElem = function(tag) {
        return $("<" + tag + "></" + tag + ">");
      };

      var globalAnchors = {};

      var getAnchorElement = function(element) {
        var radios;
        if (element.is('[type=radio]')) {
          radios = element.parents('form:first').find('[type=radio]').filter(function(i, e) {
            return $(e).attr("name") === element.attr("name");
          });
          element = radios.first();
        }
        return element;
      };

      var incr = function(obj, pos, val) {
        var opp, temp;
        if (typeof val === "string") {
          val = parseInt(val, 10);
        } else if (typeof val !== "number") {
          return;
        }
        if (isNaN(val)) {
          return;
        }
        opp = positions[opposites[pos.charAt(0)]];
        temp = pos;
        if (obj[opp] !== undefined) {
          pos = positions[opp.charAt(0)];
          val = -val;
        }
        if (obj[pos] === undefined) {
          obj[pos] = val;
        } else {
          obj[pos] += val;
        }
        return null;
      };

      var realign = function(alignment, inner, outer) {
        if (alignment === "l" || alignment === "t") {
          return 0;
        } else if (alignment === "c" || alignment === "m") {
          return outer / 2 - inner / 2;
        } else if (alignment === "r" || alignment === "b") {
          return outer - inner;
        }
        throw "Invalid alignment";
      };

      var encode = function(text) {
        encode.e = encode.e || createElem("div");
        return encode.e.text(text).html();
      };

      function Notification(elem, data, options) {
        if (typeof options === "string") {
          options = {
            className: options
          };
        }
        this.options = inherit(pluginOptions, $.isPlainObject(options) ? options : {});
        this.loadHTML();
        this.wrapper = $(coreStyle.html);
        if (this.options.clickToHide) {
          this.wrapper.addClass(pluginClassName + "-hidable");
        }
        this.wrapper.data(pluginClassName, this);
        this.arrow = this.wrapper.find("." + pluginClassName + "-arrow");
        this.container = this.wrapper.find("." + pluginClassName + "-container");
        this.container.append(this.userContainer);
        if (elem && elem.length) {
          this.elementType = elem.attr("type");
          this.originalElement = elem;
          this.elem = getAnchorElement(elem);
          this.elem.data(pluginClassName, this);
          this.elem.before(this.wrapper);
        }
        this.container.hide();
        this.run(data);
      }

      Notification.prototype.loadHTML = function() {
        var style;
        style = this.getStyle();
        this.userContainer = $(style.html);
        this.userFields = style.fields;
      };

      Notification.prototype.show = function(show, userCallback) {
        var args, callback, elems, fn, hidden;
        callback = (function(_this) {
          return function() {
            if (!show && !_this.elem) {
              _this.destroy();
            }
            if (userCallback) {
              return userCallback();
            }
          };
        })(this);
        hidden = this.container.parent().parents(':hidden').length > 0;
        elems = this.container.add(this.arrow);
        args = [];
        if (hidden && show) {
          fn = "show";
        } else if (hidden && !show) {
          fn = "hide";
        } else if (!hidden && show) {
          fn = this.options.showAnimation;
          args.push(this.options.showDuration);
        } else if (!hidden && !show) {
          fn = this.options.hideAnimation;
          args.push(this.options.hideDuration);
        } else {
          return callback();
        }
        args.push(callback);
        return elems[fn].apply(elems, args);
      };

      Notification.prototype.setGlobalPosition = function() {
        var p = this.getPosition();
        var pMain = p[0];
        var pAlign = p[1];
        var main = positions[pMain];
        var align = positions[pAlign];
        var key = pMain + "|" + pAlign;
        var anchor = globalAnchors[key];
        if (!anchor || !document.body.contains(anchor[0])) {
          anchor = globalAnchors[key] = createElem("div");
          var css = {};
          css[main] = 0;
          if (align === "middle") {
            css.top = '45%';
          } else if (align === "center") {
            css.left = '45%';
          } else {
            css[align] = 0;
          }
          anchor.css(css).addClass(pluginClassName + "-corner");
          $("body").append(anchor);
        }
        return anchor.prepend(this.wrapper);
      };

      Notification.prototype.setElementPosition = function() {
        var arrowColor, arrowCss, arrowSize, color, contH, contW, css, elemH, elemIH, elemIW, elemPos, elemW, gap, j, k, len, len1, mainFull, margin, opp, oppFull, pAlign, pArrow, pMain, pos, posFull, position, ref, wrapPos;
        position = this.getPosition();
        pMain = position[0];
        pAlign = position[1];
        pArrow = position[2];
        elemPos = this.elem.position();
        elemH = this.elem.outerHeight();
        elemW = this.elem.outerWidth();
        elemIH = this.elem.innerHeight();
        elemIW = this.elem.innerWidth();
        wrapPos = this.wrapper.position();
        contH = this.container.height();
        contW = this.container.width();
        mainFull = positions[pMain];
        opp = opposites[pMain];
        oppFull = positions[opp];
        css = {};
        css[oppFull] = pMain === "b" ? elemH : pMain === "r" ? elemW : 0;
        incr(css, "top", elemPos.top - wrapPos.top);
        incr(css, "left", elemPos.left - wrapPos.left);
        ref = ["top", "left"];
        for (j = 0, len = ref.length; j < len; j++) {
          pos = ref[j];
          margin = parseInt(this.elem.css("margin-" + pos), 10);
          if (margin) {
            incr(css, pos, margin);
          }
        }
        gap = Math.max(0, this.options.gap - (this.options.arrowShow ? arrowSize : 0));
        incr(css, oppFull, gap);
        if (!this.options.arrowShow) {
          this.arrow.hide();
        } else {
          arrowSize = this.options.arrowSize;
          arrowCss = $.extend({}, css);
          arrowColor = this.userContainer.css("border-color") || this.userContainer.css("border-top-color") || this.userContainer.css("background-color") || "white";
          for (k = 0, len1 = mainPositions.length; k < len1; k++) {
            pos = mainPositions[k];
            posFull = positions[pos];
            if (pos === opp) {
              continue;
            }
            color = posFull === mainFull ? arrowColor : "transparent";
            arrowCss["border-" + posFull] = arrowSize + "px solid " + color;
          }
          incr(css, positions[opp], arrowSize);
          if (indexOf.call(mainPositions, pAlign) >= 0) {
            incr(arrowCss, positions[pAlign], arrowSize * 2);
          }
        }
        if (indexOf.call(vAligns, pMain) >= 0) {
          incr(css, "left", realign(pAlign, contW, elemW));
          if (arrowCss) {
            incr(arrowCss, "left", realign(pAlign, arrowSize, elemIW));
          }
        } else if (indexOf.call(hAligns, pMain) >= 0) {
          incr(css, "top", realign(pAlign, contH, elemH));
          if (arrowCss) {
            incr(arrowCss, "top", realign(pAlign, arrowSize, elemIH));
          }
        }
        if (this.container.is(":visible")) {
          css.display = "block";
        }
        this.container.removeAttr("style").css(css);
        if (arrowCss) {
          return this.arrow.removeAttr("style").css(arrowCss);
        }
      };

      Notification.prototype.getPosition = function() {
        var pos, ref, ref1, ref2, ref3, ref4, ref5, text;
        text = this.options.position || (this.elem ? this.options.elementPosition : this.options.globalPosition);
        pos = parsePosition(text);
        if (pos.length === 0) {
          pos[0] = "b";
        }
        if (ref = pos[0], indexOf.call(mainPositions, ref) < 0) {
          throw "Must be one of [" + mainPositions + "]";
        }
        if (pos.length === 1 || ((ref1 = pos[0], indexOf.call(vAligns, ref1) >= 0) && (ref2 = pos[1], indexOf.call(hAligns, ref2) < 0)) || ((ref3 = pos[0], indexOf.call(hAligns, ref3) >= 0) && (ref4 = pos[1], indexOf.call(vAligns, ref4) < 0))) {
          pos[1] = (ref5 = pos[0], indexOf.call(hAligns, ref5) >= 0) ? "m" : "l";
        }
        if (pos.length === 2) {
          pos[2] = pos[1];
        }
        return pos;
      };

      Notification.prototype.getStyle = function(name) {
        var style;
        if (!name) {
          name = this.options.style;
        }
        if (!name) {
          name = "default";
        }
        style = styles[name];
        if (!style) {
          throw "Missing style: " + name;
        }
        return style;
      };

      Notification.prototype.updateClasses = function() {
        var classes, style;
        classes = ["base"];
        if ($.isArray(this.options.className)) {
          classes = classes.concat(this.options.className);
        } else if (this.options.className) {
          classes.push(this.options.className);
        }
        style = this.getStyle();
        classes = $.map(classes, function(n) {
          return pluginClassName + "-" + style.name + "-" + n;
        }).join(" ");
        return this.userContainer.attr("class", classes);
      };

      Notification.prototype.run = function(data, options) {
        var d, datas, name, type, value;
        if ($.isPlainObject(options)) {
          $.extend(this.options, options);
        } else if ($.type(options) === "string") {
          this.options.className = options;
        }
        if (this.container && !data) {
          this.show(false);
          return;
        } else if (!this.container && !data) {
          return;
        }
        datas = {};
        if ($.isPlainObject(data)) {
          datas = data;
        } else {
          datas[blankFieldName] = data;
        }
        for (name in datas) {
          d = datas[name];
          type = this.userFields[name];
          if (!type) {
            continue;
          }
          if (type === "text") {
            d = encode(d);
            if (this.options.breakNewLines) {
              d = d.replace(/\n/g, '<br/>');
            }
          }
          value = name === blankFieldName ? '' : '=' + name;
          find(this.userContainer, "[data-notify-" + type + value + "]").html(d);
        }
        this.updateClasses();
        if (this.elem) {
          this.setElementPosition();
        } else {
          this.setGlobalPosition();
        }
        this.show(true);
        if (this.options.autoHide) {
          clearTimeout(this.autohideTimer);
          this.autohideTimer = setTimeout(this.show.bind(this, false), this.options.autoHideDelay);
        }
      };

      Notification.prototype.destroy = function() {
        this.wrapper.data(pluginClassName, null);
        this.wrapper.remove();
      };

      $[pluginName] = function(elem, data, options) {
        if ((elem && elem.nodeName) || elem.jquery) {
          $(elem)[pluginName](data, options);
        } else {
          options = data;
          data = elem;
          new Notification(null, data, options);
        }
        return elem;
      };

      $.fn[pluginName] = function(data, options) {
        $(this).each(function() {
          var prev = getAnchorElement($(this)).data(pluginClassName);
          if (prev) {
            prev.destroy();
          }
          var curr = new Notification($(this), data, options);
        });
        return this;
      };

      $.extend($[pluginName], {
        defaults: defaults,
        addStyle: addStyle,
        removeStyle: removeStyle,
        pluginOptions: pluginOptions,
        getStyle: getStyle,
        insertCSS: insertCSS
      });

      //always include the default bootstrap style
      addStyle("bootstrap", {
        html: "<div>\n<span data-notify-text></span>\n</div>",
        classes: {
          base: {
            "font-weight": "bold",
            "padding": "8px 15px 8px 14px",
            "text-shadow": "0 1px 0 rgba(255, 255, 255, 0.5)",
            "background-color": "#fcf8e3",
            "border": "1px solid #fbeed5",
            "border-radius": "4px",
            "white-space": "nowrap",
            "padding-left": "25px",
            "background-repeat": "no-repeat",
            "background-position": "3px 7px"
          },
          error: {
            "color": "#B94A48",
            "background-color": "#F2DEDE",
            "border-color": "#EED3D7",
            "background-image": "url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAtRJREFUeNqkVc1u00AQHq+dOD+0poIQfkIjalW0SEGqRMuRnHos3DjwAH0ArlyQeANOOSMeAA5VjyBxKBQhgSpVUKKQNGloFdw4cWw2jtfMOna6JOUArDTazXi/b3dm55socPqQhFka++aHBsI8GsopRJERNFlY88FCEk9Yiwf8RhgRyaHFQpPHCDmZG5oX2ui2yilkcTT1AcDsbYC1NMAyOi7zTX2Agx7A9luAl88BauiiQ/cJaZQfIpAlngDcvZZMrl8vFPK5+XktrWlx3/ehZ5r9+t6e+WVnp1pxnNIjgBe4/6dAysQc8dsmHwPcW9C0h3fW1hans1ltwJhy0GxK7XZbUlMp5Ww2eyan6+ft/f2FAqXGK4CvQk5HueFz7D6GOZtIrK+srupdx1GRBBqNBtzc2AiMr7nPplRdKhb1q6q6zjFhrklEFOUutoQ50xcX86ZlqaZpQrfbBdu2R6/G19zX6XSgh6RX5ubyHCM8nqSID6ICrGiZjGYYxojEsiw4PDwMSL5VKsC8Yf4VRYFzMzMaxwjlJSlCyAQ9l0CW44PBADzXhe7xMdi9HtTrdYjFYkDQL0cn4Xdq2/EAE+InCnvADTf2eah4Sx9vExQjkqXT6aAERICMewd/UAp/IeYANM2joxt+q5VI+ieq2i0Wg3l6DNzHwTERPgo1ko7XBXj3vdlsT2F+UuhIhYkp7u7CarkcrFOCtR3H5JiwbAIeImjT/YQKKBtGjRFCU5IUgFRe7fF4cCNVIPMYo3VKqxwjyNAXNepuopyqnld602qVsfRpEkkz+GFL1wPj6ySXBpJtWVa5xlhpcyhBNwpZHmtX8AGgfIExo0ZpzkWVTBGiXCSEaHh62/PoR0p/vHaczxXGnj4bSo+G78lELU80h1uogBwWLf5YlsPmgDEd4M236xjm+8nm4IuE/9u+/PH2JXZfbwz4zw1WbO+SQPpXfwG/BBgAhCNZiSb/pOQAAAAASUVORK5CYII=)"
          },
          success: {
            "color": "#468847",
            "background-color": "#DFF0D8",
            "border-color": "#D6E9C6",
            "background-image": "url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAutJREFUeNq0lctPE0Ecx38zu/RFS1EryqtgJFA08YCiMZIAQQ4eRG8eDGdPJiYeTIwHTfwPiAcvXIwXLwoXPaDxkWgQ6islKlJLSQWLUraPLTv7Gme32zoF9KSTfLO7v53vZ3d/M7/fIth+IO6INt2jjoA7bjHCJoAlzCRw59YwHYjBnfMPqAKWQYKjGkfCJqAF0xwZjipQtA3MxeSG87VhOOYegVrUCy7UZM9S6TLIdAamySTclZdYhFhRHloGYg7mgZv1Zzztvgud7V1tbQ2twYA34LJmF4p5dXF1KTufnE+SxeJtuCZNsLDCQU0+RyKTF27Unw101l8e6hns3u0PBalORVVVkcaEKBJDgV3+cGM4tKKmI+ohlIGnygKX00rSBfszz/n2uXv81wd6+rt1orsZCHRdr1Imk2F2Kob3hutSxW8thsd8AXNaln9D7CTfA6O+0UgkMuwVvEFFUbbAcrkcTA8+AtOk8E6KiQiDmMFSDqZItAzEVQviRkdDdaFgPp8HSZKAEAL5Qh7Sq2lIJBJwv2scUqkUnKoZgNhcDKhKg5aH+1IkcouCAdFGAQsuWZYhOjwFHQ96oagWgRoUov1T9kRBEODAwxM2QtEUl+Wp+Ln9VRo6BcMw4ErHRYjH4/B26AlQoQQTRdHWwcd9AH57+UAXddvDD37DmrBBV34WfqiXPl61g+vr6xA9zsGeM9gOdsNXkgpEtTwVvwOklXLKm6+/p5ezwk4B+j6droBs2CsGa/gNs6RIxazl4Tc25mpTgw/apPR1LYlNRFAzgsOxkyXYLIM1V8NMwyAkJSctD1eGVKiq5wWjSPdjmeTkiKvVW4f2YPHWl3GAVq6ymcyCTgovM3FzyRiDe2TaKcEKsLpJvNHjZgPNqEtyi6mZIm4SRFyLMUsONSSdkPeFtY1n0mczoY3BHTLhwPRy9/lzcziCw9ACI+yql0VLzcGAZbYSM5CCSZg1/9oc/nn7+i8N9p/8An4JMADxhH+xHfuiKwAAAABJRU5ErkJggg==)"
          },
          info: {
            "color": "#3A87AD",
            "background-color": "#D9EDF7",
            "border-color": "#BCE8F1",
            "background-image": "url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3QYFAhkSsdes/QAAA8dJREFUOMvVlGtMW2UYx//POaWHXg6lLaW0ypAtw1UCgbniNOLcVOLmAjHZolOYlxmTGXVZdAnRfXQm+7SoU4mXaOaiZsEpC9FkiQs6Z6bdCnNYruM6KNBw6YWewzl9z+sHImEWv+vz7XmT95f/+3/+7wP814v+efDOV3/SoX3lHAA+6ODeUFfMfjOWMADgdk+eEKz0pF7aQdMAcOKLLjrcVMVX3xdWN29/GhYP7SvnP0cWfS8caSkfHZsPE9Fgnt02JNutQ0QYHB2dDz9/pKX8QjjuO9xUxd/66HdxTeCHZ3rojQObGQBcuNjfplkD3b19Y/6MrimSaKgSMmpGU5WevmE/swa6Oy73tQHA0Rdr2Mmv/6A1n9w9suQ7097Z9lM4FlTgTDrzZTu4StXVfpiI48rVcUDM5cmEksrFnHxfpTtU/3BFQzCQF/2bYVoNbH7zmItbSoMj40JSzmMyX5qDvriA7QdrIIpA+3cdsMpu0nXI8cV0MtKXCPZev+gCEM1S2NHPvWfP/hL+7FSr3+0p5RBEyhEN5JCKYr8XnASMT0xBNyzQGQeI8fjsGD39RMPk7se2bd5ZtTyoFYXftF6y37gx7NeUtJJOTFlAHDZLDuILU3j3+H5oOrD3yWbIztugaAzgnBKJuBLpGfQrS8wO4FZgV+c1IxaLgWVU0tMLEETCos4xMzEIv9cJXQcyagIwigDGwJgOAtHAwAhisQUjy0ORGERiELgG4iakkzo4MYAxcM5hAMi1WWG1yYCJIcMUaBkVRLdGeSU2995TLWzcUAzONJ7J6FBVBYIggMzmFbvdBV44Corg8vjhzC+EJEl8U1kJtgYrhCzgc/vvTwXKSib1paRFVRVORDAJAsw5FuTaJEhWM2SHB3mOAlhkNxwuLzeJsGwqWzf5TFNdKgtY5qHp6ZFf67Y/sAVadCaVY5YACDDb3Oi4NIjLnWMw2QthCBIsVhsUTU9tvXsjeq9+X1d75/KEs4LNOfcdf/+HthMnvwxOD0wmHaXr7ZItn2wuH2SnBzbZAbPJwpPx+VQuzcm7dgRCB57a1uBzUDRL4bfnI0RE0eaXd9W89mpjqHZnUI5Hh2l2dkZZUhOqpi2qSmpOmZ64Tuu9qlz/SEXo6MEHa3wOip46F1n7633eekV8ds8Wxjn37Wl63VVa+ej5oeEZ/82ZBETJjpJ1Rbij2D3Z/1trXUvLsblCK0XfOx0SX2kMsn9dX+d+7Kf6h8o4AIykuffjT8L20LU+w4AZd5VvEPY+XpWqLV327HR7DzXuDnD8r+ovkBehJ8i+y8YAAAAASUVORK5CYII=)"
          },
          warn: {
            "color": "#C09853",
            "background-color": "#FCF8E3",
            "border-color": "#FBEED5",
            "background-image": "url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAMAAAC6V+0/AAABJlBMVEXr6eb/2oD/wi7/xjr/0mP/ykf/tQD/vBj/3o7/uQ//vyL/twebhgD/4pzX1K3z8e349vK6tHCilCWbiQymn0jGworr6dXQza3HxcKkn1vWvV/5uRfk4dXZ1bD18+/52YebiAmyr5S9mhCzrWq5t6ufjRH54aLs0oS+qD751XqPhAybhwXsujG3sm+Zk0PTwG6Shg+PhhObhwOPgQL4zV2nlyrf27uLfgCPhRHu7OmLgAafkyiWkD3l49ibiAfTs0C+lgCniwD4sgDJxqOilzDWowWFfAH08uebig6qpFHBvH/aw26FfQTQzsvy8OyEfz20r3jAvaKbhgG9q0nc2LbZxXanoUu/u5WSggCtp1anpJKdmFz/zlX/1nGJiYmuq5Dx7+sAAADoPUZSAAAAAXRSTlMAQObYZgAAAAFiS0dEAIgFHUgAAAAJcEhZcwAACxMAAAsTAQCanBgAAAAHdElNRQfdBgUBGhh4aah5AAAAlklEQVQY02NgoBIIE8EUcwn1FkIXM1Tj5dDUQhPU502Mi7XXQxGz5uVIjGOJUUUW81HnYEyMi2HVcUOICQZzMMYmxrEyMylJwgUt5BljWRLjmJm4pI1hYp5SQLGYxDgmLnZOVxuooClIDKgXKMbN5ggV1ACLJcaBxNgcoiGCBiZwdWxOETBDrTyEFey0jYJ4eHjMGWgEAIpRFRCUt08qAAAAAElFTkSuQmCC)"
          }
        }
      });

      $(function() {
        insertCSS(coreStyle.css).attr("id", "core-notify");
        $(document).on("click", "." + pluginClassName + "-hidable", function(e) {
          $(this).trigger("notify-hide");
        });
        $(document).on("notify-hide", "." + pluginClassName + "-wrapper", function(e) {
          var elem = $(this).data(pluginClassName);
          if(elem) {
            elem.show(false);
          }
        });
      });

    }));
  </script>
  <script>
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(";");
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == " ") {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function checkCookie() {

        if (d3stripesSku == "") {
          setCookie("d3stripesSku", "S81910", 365);
        }

//      if (d3stripesDuplicate == "") {
//        setCookie("d3stripesDuplicate", "x-PrdRt", 365);
//      }

        if (d3stripesDuplicate == "") {
          setCookie("d3stripesDuplicate", "WdHMR0cnJ", 365);
        }

        var d3stripesSku = getCookie("d3stripesSku");
        if (d3stripesSku == "") {
          setCookie("d3stripesSku", "S81910", 365);
        }

//      var d3stripesDuplicate = getCookie("d3stripesDuplicate");
//      if (d3stripesDuplicate == "") {
//        setCookie("d3stripesDuplicate", "x-PrdRt", 365);
//      }

        var d3stripesDuplicate = getCookie("d3stripesDuplicate");
        if (d3stripesDuplicate == "") {
          setCookie("d3stripesDuplicate", "WdHMR0cnJ", 365);
        }

        var d3stripesTimeOut = getCookie("d3stripesTimeOut");
        if (d3stripesTimeOut == "") {
          setCookie("d3stripesTimeOut", "10", 365);
        }

        var d3stripesRefresh = getCookie("d3stripesRefresh");
        if (d3stripesRefresh == "") {
          setCookie("d3stripesRefresh", "True", 365);
        }

        var d3stripesLocale = getCookie("d3stripesLocale");
        if (d3stripesLocale == "") {
          setCookie("d3stripesLocale", "US", 365);
        }

        var d3stripesInventoryClient = getCookie("d3stripesInventoryClient");
        if (d3stripesInventoryClient == "") {
          setCookie("d3stripesInventoryClient", "Yes", 365);
        }

        var d3stripesInventoryVariants = getCookie("d3stripesInventoryVariants");
        if (d3stripesInventoryVariants == "") {
          setCookie("d3stripesInventoryVariants", "No", 365);
        }

        var d3stripesClientId = getCookie("d3stripesClientId");
        if (d3stripesClientId == "") {
          setCookie("d3stripesClientId", "2904a24b-e4b4-4ef7-89a4-2ebd2d175dde", 365);
        }
        var d3stripesSiteKey = getCookie("d3stripesSiteKey");
        if (d3stripesSiteKey == "") {
          setCookie("d3stripesSiteKey", "6LeOnCkTAAAAAK72JqRneJQ2V7GvQvvgzsVr-6kR", 365);
        }
    }
  </script>
  <style>
    @font-face {
      font-family: yeezy-tstar-strong;
      src: url(data:font/truetype;charset=utf-8;base64,AAEAAAAUAQAABABAR1BPUzLILDgAALwcAAAKMkdTVUJk+GUCAADGUAAAAIBMVFNI7k3gAQAAB0gAAAFMT1MvMps9u+UAAAHIAAAAYFZETVhxl3kZAAAIlAAABeBjbWFwMWQ3dQAALFAAAAeSY3Z0IAOuC1AAADYUAAAAImZwZ20GWZw3AAAz5AAAAXNnYXNwABcACQAAvAwAAAAQZ2x5Zn3k7SUAADY4AABu7GhkbXj5NQcRAAAOdAAAHdxoZWFkh+u6ZwAAAUwAAAA2aGhlYQ27BbwAAAGEAAAAJGhtdHhJY3x0AAACKAAABSBrZXJuDncUAwAAp7gAAANsbG9jYX2fX6oAAKUkAAACkm1heHADXgIkAAABqAAAACBuYW1lzPdQRQAAqyQAAAlocG9zdFofsiwAALSMAAAHfnByZXCWYj8fAAA1WAAAALoAAQAAAAEAgxvVHyJfDzz1ABkIAAAAAABPe45mAAAAANNV4Dv/sv43BjsIDgAAAAkAAgAAAAAAAAABAAAGMf4xAZoGy/+y/3cGOwABAAAAAAAAAAAAAAAAAAABSAABAAABSABZAAUAVgAEAAEAAAAAAAoAAAIAAXMAAgABAAMEIAK8AAUACAWaBTMAAAEfBZoFMwAAA9EAZgIACA8CAAgGAwAAAgAEAAAAIwAAAAoAAAAAAAAAAHB5cnMAQAAgISIGMf4xAZoHrgG6AAAAAgAAAAAEMwW0ACAAIAACAZoAAAGuAAACLQCeBDEAWAbDAIcFNwCBAnkAiwJ9AJgEewCHAi0APwOsAJECLQCBBA4AkQQdAFoEJQCPBBIAYgQZAGYELQB1BBQAXgQZAGYEFABSBCkAWgQZAGYCLQCBAkwAPwRcAJMEwQDbBGAAoAOLAB8FKQDJBHsAKQRcAI8EGQBmBFIAjwQfAI8EHwCPBC0AZgSaAI8CCgCPA6IAFARGAI8EHQCPBUQAjwSHAI8ELQBmBCsAjwRWAHsEbwCPBCUAUgPHAB8EVAB7BFQAKQZIACkELwApBCMAKQQjAGYCzwCsBBQAWAbLAJwGywCcBewAewLNAKwD8gA1A/IAcwR1ACUEewApBB8AjwR7ACkEHwCPAgAAiQIA/7ICAP/bBFYAegRWAHoEVgB6BFQAewRUAHsEVAB7A88AngRmAE4EJQCTBfIAgwWyAHUFxwCJBKgA1QQdACkEGf/jBKIAkQaBAI0EewApBFwAjwQZAGYEUgCPBB8AjwQfAI8ELQBmBJoAjwIKAI8DogAUBEYAjwQdAI8FRACPBIcAjwQtAGYEKwCPBFYAewRvAI8EJQBSA8cAHwRUAHsEVAApBkgAKQQvACkEIwApBCMAZgR1ACUEewApBHsAKQQfAI8EVAB7BFQAewRUAHsEVgB6BFYAegRWAHoCAP/bAgD/sgIAAIkEJQCTBB8AjwQjAGYEIwBmBHsAKQQfAI8EGQBmBBkAZgQtAGYEVAB7AucAmgJzAC0DgwB1BHsAKQR7ACkELQBmBFQAewR7ACkEHwCPAgr/uQIK/7kCMwBYAjEAewHRAHsDJwB7AnEANQJvAHMD1QC0A5YAqAPTAMMCAACRA+EAsgPTAJ4CqACaBjkAKQY5ACkGdQBxBnUAcQRSABQEHQAUBB0AFARxAIEEcQCBBHsAKQR7ACkEewApBHsAKQY5ACkEewApBHsAKQR7ACkEewApBjkAKQQZAGYEGQBmBBkAZgQZAGYEGQBmBBkAZgQZAGYEGQBmBFIAjwRSABQEUgCPBFIAFAQfAI8EHwCPBB8AjwQfAI8EHwCPBB8AjwQfAI8EHwCPBB8AjwQfAI8ELQBmBC0AZgQtAGYELQBmBC0AZgQtAGYELQBmBC0AZgSaABQEmgAUBJoAjwSaAI8CCv/gAgoAjwIK/+MCCgCPAgr/zwOiABQCCv/gAgr/4wIKAI8CCv/PA6IAFARGAI8ERgCPBB0AjwQdAI8EHQCPBB0AjwQdAI8EHQCPBB0AjwQdAI8EhwCPBIcAjwSHAI8EhwCPBIcAjwSHAI8EhwCPBIcAjwQtAGYELQBmBC0AZgQtAGYELQBmBC0AMQQtADEELQBmBC0AZgQtADEELQAxBC0AZgRvAI8EbwCPBG8AjwQlAFIEJQBSBCUAUgQlAFIEJQBSA8cAHwPHAB8DxwAfBCUAUgQlAFIEJQBSBCUAUgQlAFIDxwAfA8cAHwRUAHsEVAB7BFQAewRUAHsEVAB7BFQAewZIACkGSAApBkgAKQZIACkEbwCPBG8AjwRvAI8EVAB7BFQAewRUAHsEVAB7BFQAewRUAHsGSAApBkgAKQZIACkGSAApBCMAKQQjACkEIwApBCMAKQQjAGYEIwBmBCMAZgQjACkEIwApBCMAKQQjACkEIwBmBCMAZgQjAGYEIwBmBCMAZgQjAGYEIwBmBCMAZgQjAGYEVAB7BFQAewRUAHsEVAB7BFQAewRUAHsEUgAUA8cAHwIIAIkEhwCPBIcAjwAAAUgBAQFMREwBRAEBAUwBLwFEOys3TAErO0xMAQEBRDcBREw7AQFMOwFMAQFETEw7IjtMAUwBAQEBAQE7OzNEAQEBAQEBAQEBAQEBAQEBAQEBTAE7TDsBAQEBAQFETDsBAUw7AUwBAURMTDsiO0wBTAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQFMAUwBAQEBAQEBAQEBASYBAQEBAQEBAQEBAQEBOwEBRAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBOwEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQFMAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAUwBTAFMATsBAUwBAAAAAQABAQEBAQAMAPgI/wAIAAj//gAJAAn//gAKAAr//QALAAv//QAMAAz//QANAA3//QAOAA7//AAPAA///AAQABD//AARABH//AASABL//AATABP/+wAUABT/+wAVABX/+wAWABb/+wAXABf/+wAYABj/+gAZABj/+gAaABn/+gAbABr/+gAcABv/+QAdABz/+QAeAB3/+QAfAB7/+QAgAB//+QAhACD/+AAiACH/+AAjACL/+AAkACP/+AAlACT/+AAmACX/9wAnACb/9wAoACf/9wApACj/9wAqACn/9gArACr/9gAsACv/9gAtACz/9gAuAC3/9gAvAC7/9QAwAC//9QAxADD/9QAyADD/9QAzADH/9AA0ADL/9AA1ADP/9AA2ADT/9AA3ADX/9AA4ADb/8wA5ADf/8wA6ADj/8wA7ADn/8wA8ADr/8wA9ADv/8gA+ADz/8gA/AD3/8gBAAD7/8gBBAD//8QBCAED/8QBDAEH/8QBEAEL/8QBFAEP/8QBGAET/8ABHAEX/8ABIAEb/8ABJAEf/8ABKAEj/8ABLAEj/7wBMAEn/7wBNAEr/7wBOAEv/7wBPAEz/7gBQAE3/7gBRAE7/7gBSAE//7gBTAFD/7gBUAFH/7QBVAFL/7QBWAFP/7QBXAFT/7QBYAFX/7QBZAFb/7ABaAFf/7ABbAFj/7ABcAFn/7ABdAFr/6wBeAFv/6wBfAFz/6wBgAF3/6wBhAF7/6wBiAF//6gBjAGD/6gBkAGD/6gBlAGH/6gBmAGL/6QBnAGP/6QBoAGT/6QBpAGX/6QBqAGb/6QBrAGf/6ABsAGj/6ABtAGn/6ABuAGr/6ABvAGv/6ABwAGz/5wBxAG3/5wByAG7/5wBzAG//5wB0AHD/5gB1AHH/5gB2AHL/5gB3AHP/5gB4AHT/5gB5AHX/5QB6AHb/5QB7AHf/5QB8AHj/5QB9AHj/5QB+AHn/5AB/AHr/5ACAAHv/5ACBAHz/5ACCAH3/4wCDAH7/4wCEAH//4wCFAID/4wCGAIH/4wCHAIL/4gCIAIP/4gCJAIT/4gCKAIX/4gCLAIb/4gCMAIf/4QCNAIj/4QCOAIn/4QCPAIr/4QCQAIv/4ACRAIz/4ACSAI3/4ACTAI7/4ACUAI//4ACVAJD/3wCWAJD/3wCXAJH/3wCYAJL/3wCZAJP/3gCaAJT/3gCbAJX/3gCcAJb/3gCdAJf/3gCeAJj/3QCfAJn/3QCgAJr/3QChAJv/3QCiAJz/3QCjAJ3/3ACkAJ7/3AClAJ//3ACmAKD/3ACnAKH/2wCoAKL/2wCpAKP/2wCqAKT/2wCrAKX/2wCsAKb/2gCtAKf/2gCuAKj/2gCvAKj/2gCwAKn/2gCxAKr/2QCyAKv/2QCzAKz/2QC0AK3/2QC1AK7/2AC2AK//2AC3ALD/2AC4ALH/2AC5ALL/2AC6ALP/1wC7ALT/1wC8ALX/1wC9ALb/1wC+ALf/1gC/ALj/1gDAALn/1gDBALr/1gDCALv/1gDDALz/1QDEAL3/1QDFAL7/1QDGAL//1QDHAMD/1QDIAMD/1ADJAMH/1ADKAML/1ADLAMP/1ADMAMT/0wDNAMX/0wDOAMb/0wDPAMf/0wDQAMj/0wDRAMn/0gDSAMr/0gDTAMv/0gDUAMz/0gDVAM3/0gDWAM7/0QDXAM//0QDYAND/0QDZANH/0QDaANL/0ADbANP/0ADcANT/0ADdANX/0ADeANb/0ADfANf/zwDgANj/zwDhANj/zwDiANn/zwDjANr/zwDkANv/zgDlANz/zgDmAN3/zgDnAN7/zgDoAN//zQDpAOD/zQDqAOH/zQDrAOL/zQDsAOP/zQDtAOT/zADuAOX/zADvAOb/zADwAOf/zADxAOj/ywDyAOn/ywDzAOr/ywD0AOv/ywD1AOz/ywD2AO3/ygD3AO7/ygD4AO//ygD5APD/ygD6APD/ygD7APH/yQD8APL/yQD9APP/yQD+APT/yQD/APX/yAAAABcAAAFMCQgCAgIFCAUDAwUCBAMFBQUFBQUFBQUFBQMDBQUFBQYFBQUFBQUFBgIFBQUGBQUFBQUFBAUFBwUFBQMFCAgHAwQEBQUFBQUCAgIFBQUFBQUEBgUHBwcFBQUFBwUFBQUFBQUGAgUFBQYFBQUFBQUEBQUHBQUFBQUFBQUFBQUFBQICAgUFBQUFBQUFBQUEAwQFBQUFBQUCAgICAgQDAwQEBAIEBAMHBwcHBQUFBgUFBQUFBwUFBQUHBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBgUFBQICAgICBAICAgIEBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUEBAQFBQUFBQQEBQUFBQUFBwcHBwUFBQUFBQUFBQcHBwcFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUEAgUFAAAKCQICAwYJBwMDBgMFAwUGBQUFBgYFBQYFAwMFBgUFBgYGBgYFBQYGAwUFBQcGBgYGBgYFBgUIBQUFBAYJCQgEBQUGBgUGBQMDAwUFBQUFBQUGBQgICAYFBQYIBgYGBgUFBgYDBQUFBwYGBgYGBgUGBQgFBQUGBgYFBQUFBQUFAwMDBQUFBQYFBQUFBQQDBQYGBQUGBQMDAwMCBAMDBQQFAwUFAwgICAgGBQUGBgYGBgYIBgYGBggFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUGBgYGAwMDAwMFAwMDAwUFBQUFBQUFBQUFBgYGBgYGBgYFBQUFBQYFBQUFBQUGBgYFBQUFBQUFBQUFBQUFBQUFBQUFBQUICAgIBgYGBQUFBQUFCAgICAUFBQUFBQUFBQUFBQUFBQUFBQUFBgUGBQYFBgUDBgYAAAsKAgIDBgkHAwQGAwUDBgYGBgYGBgYGBgYDAwYHBgYHBgYGBgYGBgYDBQYGBwYGBgYGBgUGBgkGBgYEBgoKCAQFBQYGBgYGAwMDBgYGBgYGBQYGCAgIBgYGBgkGBgYGBgYGBgMFBgYHBgYGBgYGBQYGCQYGBgYGBgYGBgYGBgYDAwMGBgYGBgYGBgYGBAMFBgYGBgYGAwMDAwMFAwMFBQUDBQUECQkJCQYGBgYGBgYGBgkGBgYGCQYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYDAwMDAwUDAwMDBQYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBQUFBgYGBgYFBQYGBgYGBgkJCQkGBgYGBgYGBgYJCQkJBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBQMGBgAADAoCAwMGCggEBAcDBgMGBgYGBgYGBgYGBgMDBwcHBgcHBwYHBgYGBwMFBgYIBwYHBwcGBgYHCQYGBgQGCgoJBAYGBwcGBwYDAwMHBwcHBwcGBwYJCQkHBgYHCgcHBgcGBgYHAwUGBggHBgcHBwYGBgcJBgYGBwcHBgcHBwcHBwMDAwYGBgYHBgYGBgcFBAUHBwYHBwYDAwMDAwUEBAYFBgMGBgQJCQoKBwYGBwcHBwcHCQcHBwcJBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBwcHBwMDAwMDBQMDAwMFBgYGBgYGBgYGBgcHBwcHBwcHBgYGBgYGBgYGBgYGBwcHBgYGBgYGBgYGBgYGBgYGBwcHBwcHCQkJCQcHBwcHBwcHBwkJCQkGBgYGBgYGBgYGBgYGBgYGBgYGBgYHBgcGBwcGAwcHAAANCwMDBAcLCAQEBwQGAwcHBwcHBwcHBwcHAwMHCAcGCAcHBwcHBwcHAwYHBwgHBwcHBwcGBwcKBwcHBQcLCwoFBgYHBwcHBwMDAwcHBwcHBwYHBwoJCQgHBwgLBwcHBwcHBwcDBgcHCAcHBwcHBwYHBwoHBwcHBwcHBwcHBwcHAwMDBwcHBwcHBwcHBwUEBgcHBwcHBwMDBAQDBQQEBgYGAwYGBAoKCwsHBwcHBwcHBwcKBwcHBwoHBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHAwMDAwMGAwMDAwYHBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwYGBgcHBwcHBgYHBwcHBwcKCgoKBwcHBwcHBwcHCgoKCgcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwYDBwcAAA8MAwMECAwJBQQIBAcECAcIBwcIBwcIBwcEBAgJCAcJCAgHCAgIBwgEBggICQgHCAgIBwcICAwICAgFBwwMCwUHBwgICAgIBAQECAgICAgIBwgICwoLCQgICQwICAcICAgHCAQGCAgJCAcICAgHBwgIDAgICAgICAgICAgICAgEBAQICAgICAgICAgIBQUGCAgICAgIBAQEBAMFBQUHBwcEBwcFDAwMDAgICAgICAgICAwICAgIDAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJCQkEBAQEBAcEBAQEBwgICAgICAgICAgICAgICAgICAgICAgIBwgICAgICAgICAgICAgIBwcHCAgICAgHBwgICAgICAwMDAwICAgICAgICAgMDAwMCAgICAgICAgICAgICAgICAgICAgICAgICAgIBwQICAAAEA4DAwQJDgoFBQkEBwQICQgJCQkJCQgJCQQECQoJCAsJCQkJCAgJCQQHCQgLCQkJCQkJCAkJDQgICAYJDg4MBggICQkICQgEBAQJCQkJCQkICQgMDAwJCAgJDQkJCQkICAkJBAcJCAsJCQkJCQkICQkNCAgICQkJCAkJCQkJCQQEBAgICAgJCAgICAkHBQcJCQgJCQgEBAQEBAcFBQgHCAQICAUMDA0NCQgICQkJCQkJDAkJCQkMCAgICAgICAgJCQkJCAgICAgICAgICAgICAgICAgICQkJCQQEBAQEBwQEBAQHCQkICAgICAgICAkJCQkJCQkJCAgICAgJCAgICAgICQkJCAgICAgICAgICAgICAgICQkJCQkJDQ0NDQkJCQkJCQkJCQ0NDQ0ICAgICAgICAgICAgICAgICAgICAkJCQkJCQkIBAkJAAARDwMEBQkODAUFCgUIBAkJCQkJCQkJCQkJBAQJCgkICwoJCQkJCQkKBAgJCQsJCQkJCQkICQkNCQkJBgkPDg0GCAgJCgkKCQQEBAkJCQkJCQgKCQ0NDAoJCQoOCgkJCQkJCQoECAkJCwkJCQkJCQgJCQ0JCQkJCgoJCQkJCQkJBAQECQkJCQoJCQkJCQcFCAoKCQkKCQQEBQUEBwUFCAgIBAgIBg0NDg4JCQkKCQoKCgoNCgoKCg0JCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkKCgoKBAQEBAQIBAQEBAgJCQkJCQkJCQkJCgoKCgoKCgoJCQkJCQkJCQkJCQkJCQkJCQkJCQgICAkJCQkJCAgJCQkJCQkNDQ0NCQkJCQkJCQkJDQ0NDQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQgECQoAABMQBAQFChAMBgYLBQkFCgoKCgoKCgoKCgoFBQoLCgkMCwoKCgoKCgoFCAoKDAoKCgoKCgkKCg8KCgoHChAQDgcJCQsLCgsKBQUFCgoKCgoKCQsKDg4OCwoKCw8LCgoKCgoKCgUICgoMCgoKCgoKCQoKDwoKCgsLCwoKCgoKCgoFBQUKCgoKCwoKCgoKBwYICwsKCgsKBQUFBQQHBgYJCQkFCQkGDw8PDwoKCgoLCwsLCw8LCwsLDwoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoLCwsFBQUFBQkFBQUFCQoKCgoKCgoKCgoLCwsLCwsLCwoKCgoKCgoKCgoKCgsLCwoKCgoKCQkJCgoKCgoJCQoKCgoKCg8PDw8LCwsKCgoKCgoPDw8PCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCQUKCwAAFRIEBAYLEQ0GBgwGCgQLCgsKCgsKCgsLCgQGCwwLCg0MCwoLCwsKCwUJCwsNCwsLCwsLCgsLEAsLCwcKEhIPBwoKDAwLDAsFBQULCwsLCwsKCwsPDw8MCwsMEQwLCgsLCwoLBQkLCw0LCwsLCwsKCwsQCwsLDAwMCwsLCwsLCwUFBQsLCwsMCwsLCwsJBgkMDAsLDAsFBQYGBQgGBgoJCgUKCgcQEBERCwsLCwwMDAwMEAwMDAwQCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwwMDAUFBQUFCgUFBQUKCwsLCwsLCwsLCwwMDAwMDAwMCwsLCwsLCwsLCwsLDAwMCwsLCwsKCgoLCwsLCwoKCwsLCwsLEBAQEAwMDAsLCwsLCxAQEBALCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsKBQsMAAAYFAUFBwwUDwcIDQcLBwwLDAsLDAwLDAwLBwcNDg0LDw0MDAwMDAwNBgoNDA8NDAwMDAwLDA0TDQwMCAwUFBEIDAwNDQwNDAYGBg0NDQ0NDQsNDBIREg4MDA4UDQwMDAwMDA0GCg0MDw0MDAwMDAsMDRMNDAwNDQ0MDQ0NDQ0NBgYGDAwMDA0MDAwNDQkHCg0NDQ0NDAYGBwcFCQcHDAsLBgwLCBMTExMMDAwMDQ0NDQ0TDQ0NDRMMDAwMDAwMDA0NDQ0MDAwMDAwMDAwMDQ0NDQ0NDQ0NDg4OBgYGBgYLBgYGBgsNDQwMDAwMDAwMDg4ODg4ODg4NDQ0NDQwNDQ0NDQ0NDQ0MDAwMDAsLCwwMDAwMCwsNDQ0NDQ0TExMTDQ0NDQ0NDQ0NExMTEwwMDAwMDAwMDAwMDAwMDAwMDAwMDA0MDQwNDAsGDQ4AABsXBQYHDhcRCAkPBwwHDg0ODQ0PDg0ODg0HBw8QDwwSDw4ODg4ODhAHDQ4OEg8ODg8PDg0PDxUODg4JDhcXFQkNDQ8PDg8OBwcHDw8PDw8PDQ8OFRQUEA4OEBYPDg4ODg4OEAcNDg4SDw4ODw8ODQ8PFQ4ODg8PDw4PDw8PDw8HBwcODg4ODw4ODg4PCggMDw8ODw8OBwcHBwYLCAgNDA0HDQ0JFRUWFg4ODg4PDw8PDxUPDw8PFQ4ODg4ODg4ODw8PDw4ODg4ODg4ODg4ODg4ODg4ODhAQEBAHBwcHBwwHBwcHDA4ODg4ODg4ODg4PDw8PDw8PDw4ODg4ODg4ODg4ODg8PDw4ODg4ODQ0NDg4ODg4NDQ8PDw8PDxUVFRUPDw8PDw8PDw8VFRUVDg4ODg4ODg4ODg4ODg4ODg4ODg4PDw8PDw8ODQcPDwAAHRkGBggPGBIJCRAIDQgPDg8ODw8ODw8PDwgIEBEQDRMQDw4PDw8OEAcNDw8TEA4PEBAPDhAQFw8PDwoOGRkWCg4OEBAPEA8HBwcQEBAQEBAOEA8WFRURDw8RGBAPDg8PDw4QBw0PDxMQDg8QEA8OEBAXDw8PEBAQDxAQEBAQEAcHBw8PDw8QDw8PDxAKCQ0QEA8QEA8HBwgIBwwJCQ4NDgcODgoXFxcXDw8PEBAQEBAQFxAQEBAXDw8PDw8PDw8QEBAQDw8PDw8PDw8PDw8PDw8PDw8PEBEREQcHBwcHDQcHBwcNDw8PDw8PDw8PDxAQEBAQEBAQDw8PDw8ODw8PDw8PEBAQDw8PDw8ODg4PDw8PDw4OEBAQEBAQFxcXFxAQEBAQEBAQEBcXFxcPDw8PDw8PDw8PDw8PDw8PDw8PDxAQEBAQEA8OBxAQAAAgGwYHCRAbFAoKEgkPCRAQERAQEQ8QEBAQCQkRExIOFBIRDxEQEBARCA4REBQREBARERAPEREZERERCw8bGxgLEBASEhASEAgICBEREREREQ8RERgXFxMQEBMaEhEPERAQEBEIDhEQFBEQEBEREA8RERkRERESEhIQERERERERCAgIERARERIQEBAREQwKDhISERESEAgICQkHDAoKDw4PCBAPCxkZGhoREBAREhISEhIZEhISEhkQEBAQEBAQEBEREREQEBAQEBAQEBAQEREREREREREREhISCAgICAgPCAgICA8RERAQEBAQEBAQEhISEhISEhIRERERERARERERERESEhIREREREQ8PDxERERERDw8REREREREZGRkZEhISERERERERGRkZGREREREREREREREREREREREREREREREREREREQ8IERIAACEcBwcJEBsVCgoSCQ8JEREREBAREBAREBAJCRIUEg8VEhIQERERERIIDhIRFRIREBEREBAREhoREREMEBscGAwQEBISERIRCAgIEhISEhISEBERGBgYExERExsSEhAREREREggOEhEVEhEQEREQEBESGhERERISEhESEhISEhIICAgREREREhERERESDAoOEhIREhIRCAgJCQgNCgoQDxAIEBALGhobGxERERISEhISEhoSEhISGhEREREREREREhISEhERERERERERERERERERERERERITExMICAgICA8ICAgIDxISERERERERERETExMTExMTExERERERERERERERERISEhEREREREBAQEREREREQEBISEhISEhoaGhoSEhISEhISEhIaGhoaEREREREREREREREREREREREREREREhESERIREAgSEwAAJSAHCAoUHxgLCxUKEQkTExMTExMTExMTEwkLFBYUERgVFBIUExMTFQkQFBMZFRMTFBQTERQUHRMTEw0TICAbDRISFRUTFRMJCQkUFBQUFBQSFBMcGxsWExMVHhUUEhQTExMVCRAUExkVExMUFBMRFBQdExMTFRUVExQUFBQUFAkJCRMTExMVExMTExQNCxAVFRMUFRMJCQoKCA4LCxIREgkSEgwdHR4eFBMTFBUVFRUVHRUVFRUdExMTExMTExMUFBQUExMTExMTExMTExMTExMTExMTFRUVFQkJCQkJEQkJCQkRFBQTExMTExMTExUVFRUVFRUVExMTExMTExMTExMTFRUVExMTExMRERETExMTExERFBQUFBQUHR0dHRUVFRQUFBQUFB0dHR0TExMTExMTExMTExMTExMTExMTExQUFBQUFBQRCRUVAAAqJAgJCxUjGg0NGAsTDBUVFhUVFRUVFRUVDAwXGRcTGxgWFRYWFhUXCxMWFhsXFRUXFxUUFhchFhYWDxUkJCAPFRUXGBYYFgsLCxcXFxcXFxQWFiAfHxgWFhgiGBYVFhYWFRcLExYWGxcVFRcXFRQWFyEWFhYXGBgWFxcXFxcXCwsLFhYWFhgWFhYWFw8NERgYFhcYFgsLDAwKEQ0NFBMUCxQUDiEhIiIWFhYWFxgYGBghGBgYGCEWFhYWFhYWFhcXFxcWFhYWFhYWFhYWFhYWFhYWFhYXGBgYCwsLCwsTCwsLCxMWFhYWFhYWFhYWGBgYGBgYGBgWFhYWFhUWFhYWFhYXFxcWFhYWFhQUFBYWFhYWFBQXFxcXFxchISEhFxcXFxcXFxcXISEhIRYWFhYWFhYWFhYWFhYWFhYWFhYWFhcWFxYXFhQLFxgAAC4nCQoNGCceDg4aDRUNFxcYFxcYFxcXGBcNDRkbGRQeGhgXGBgYFxoMFRkYHhoXFxkZGBYZGSQYGBgQFycnIxAXFxoaGBoYDAwMGRkZGRkZFhoYIyIiGxgYGyUaGBcYGBgXGgwVGRgeGhcXGRkYFhkZJBgYGBoaGhgZGRkZGRkMDAwYGBgYGhgYGBgZEA4UGhoYGRoYDAwNDQoSDg4WFRYMFhYPJCQlJRgYGBkaGhoaGiQaGhoaJBgYGBgYGBgYGRkZGRgYGBgYGBgYGBgYGBgYGBgYGBoaGhoMDAwMDBUMDAwMFRkZGBgYGBgYGBgaGhoaGhoaGhgYGBgYFxgYGBgYGBoaGhgYGBgYFhYWGBgYGBgWFhkZGRkZGSQkJCQaGhoZGRkZGRkkJCQkGBgYGBgYGBgYGBgYGBgYGBgYGBgZGRkZGRkYFgwaGgAAMisKCw4aKiEPDxwOFw0ZGhoZGhoaGhkaGg0PGx4bFiEcHBobGhoaHg0XGxoiHRoaGxwaGBsbJxoaGhIaKyslEhkZHBwaHBoNDQ0bGxsbGxsYHBolJCQdGhodKRwcGhsaGhoeDRcbGiIdGhobHBoYGxsnGhoaHBwcGhsbGxsbGw0NDRoaGhocGhoaGhsSDxccHBobHBoNDQ4OCxQPDxgWGA0YGBEnJygoGxoaHBwcHBwcJxwcHBwnGhoaGhoaGhobGxsbGhoaGhoaGhoaGhoaGhoaGhoaHh0dHQ0NDQ0NFw0NDQ0XGxsaGhoaGhoaGhwcHBwcHBwcGhoaGhoaGhoaGhoaHBwcGhoaGhoYGBgaGhoaGhgYGxsbGxsbJycnJxwcHBsbGxsbGycnJycaGhoaGhoaGhoaGhoaGhoaGhoaGhsbGxsbGxsYDR0cAAA2LgsLDxwuIxERHg8ZDxscHBwcHBscHBwcDxAdIB4YIh4eGx0cHBwfDhgdHCQfHBwdHRwaHR0qHBwcExsuLigTGxseHhweHA4ODh0dHR0dHRoeHCgmKB8cHB8sHh4bHRwcHB8OGB0cJB8cHB0dHBodHSocHBweHh4cHR0dHR0dDg4OHBwcHB4cHBwcHRQRGB4eHB0eHA4ODw8MFRAQGhgaDhoaEioqLCwdHBweHh4eHh4qHh4eHiocHBwcHBwcHB0dHR0cHBwcHBwcHBwcHBwcHBwcHBwfHx8fDg4ODg4ZDg4ODhkdHRwcHBwcHBwcHx8fHx8fHx8cHBwcHBwcHBwcHBweHh4cHBwcHBoaGhwcHBwcGhodHR0dHR0qKioqHh4eHR0dHR0dKioqKhwcHBwcHBwcHBwcHBwcHBwcHBwcHR0dHR0dHRoOHx8AADoyDAwQHzElEhIgEBsQHR4eHR0eHh4eHh0QECAiIBklICAeIB4eHyIPGh8eJiEfHx8hHRsfHy4eHh4UHTIxKxQdHSAgHiAeDw8PHx8fHx8fHCAeLCorIh4eIi8gIB4gHh4fIg8aHx4mIR8fHyEdGx8fLh4eHiAgIB4fHx8fHx8PDw8eHh4eIB4eHh4fFRIZICAeHyAeDw8QEA0XEhIcGhwPHBwTLS0vLyAeHiEgICAgIC0gICAgLR4eHh4eHh4eHx8fHx4eHh4eHh4eHh4eHh4eHh4eHiIhISEPDw8PDxoPDw8PGh8fHh4eHh4eHh4hISEhISEhIR4eHh4eHx4eHh4eHiAgIB4eHh4eGxsbHh4eHh4bGx8fHx8fHy4uLi4gICAfHx8fHx8uLi4uHh4eHh4eHh4eHh4eHh4eHh4eHh4fHx8fHx8gGw8hIQAAQzkNDhIkOCsVFCYSHxIiIiMhIiMiIyIjIhIUJSglHSsmJCMkIyMjJxEfJCItJyMjJCUiICUkNSMjIxgiOTkxFyEhJSYjJiMREREkJCQkJCQgJSMyMDAnIiInNiYkIyQjIyMnER8kIi0nIyMkJSIgJSQ1IyMjJSYm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AQIAAP//AFL/7gPTB4ECJgAwAAAABwBOADMB8P//AFL+RgPTBcECJgAwAAAABwCLAQIAAP//AB8AAAOoBbQCBgEIAAD//wAf/kYDqAW0AiYAMQAAAAcAiwCLAAD//wB7/+4D2QdiAiYAMgAAAAcAnQA/AYH//wB7/+4D2Qd9AiYAMgAAAAcAnwBiAYH//wB7/+4D2QcUAiYAMgAAAAcAnABeAYH//wB7/jcD2QW0AiYAMgAAAAcAoQEX/7j//wB7/+4D2QeuAiYAMgAAAAcAigC4AYH//wB7/+4D2Qc1AiYAMgAAAAcAmwA/AYH//wApAAAGHweOAiYANAAAAAcAPQIlAez//wApAAAGHweBAiYANAAAAAcATgE5AfD//wApAAAGHwdOAiYANAAAAAcAjAFiAYH//wApAAAGHweOAiYANAAAAAcAOAFYAez//wCPAAAEHQeOAiYALwAAAAcAPQDRAez//wCPAAAEHQd3AiYALwAAAAcAoAA5AfD//wCP/kYEHQW0AiYALwAAAAcAiwD4AAD//wB7/+4D2QdiAiYAMgAAAAcAnQA/AYH//wB7/+4D2Qd9AiYAMgAAAAcAnwBiAYH//wB7/+4D2QcUAiYAMgAAAAcAnABeAYH//wB7/jcD2QW0AiYAMgAAAAcAoQEX/7j//wB7/+4D2QeuAiYAMgAAAAcAigC4AYH//wB7/+4D2Qc1AiYAMgAAAAcAmwA/AYH//wApAAAGHweOAiYANAAAAAcAPQIlAez//wApAAAGHweBAiYANAAAAAcATgE5AfD//wApAAAGHwdOAiYANAAAAAcAjAFiAYH//wApAAAGHweOAiYANAAAAAcAOAFYAez//wApAAAD+geOAiYANgAAAAcAPQDVAez//wApAAAD+geBAiYANgAAAAcATgAnAfD//wApAAAD+gdOAiYANgAAAAcAjABQAYH//wApAAAD+geOAiYANgAAAAcAOACDAez//wBmAAADvAeOAiYANwAAAAcAPQDBAez//wBmAAADvAd3AiYANwAAAAcAoAAnAfD//wBmAAADvAdEAiYANwAAAAcAngEQAYH//wApAAAD+geOAiYANgAAAAcAPQDVAez//wApAAAD+geBAiYANgAAAAcATgAnAfD//wApAAAD+gdOAiYANgAAAAcAjABQAYH//wApAAAD+geOAiYANgAA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A1YDcAPSBA4EmAUMBVAFvAZOBngHWgfoCCwIXgiCCK4I0AlkCigKZArmC1ILtAwEDEgMwg0iDUoNlg32DioOtg8uD5AP+BBwEOgRehGyEgwSPBKEEtQTLBOKE6YUIhUKFfgWbBaIFrYW4hbuFvoXBhcSFx4XKhc2F0IXThdaF2YXchd+F4oXrBhoGHQZKBmqGlQafBsWGzAbShtkG6AcIhyOHPAdQB2EHf4eXh5mHrIfEh9GH9IgSiCsIRQhjCIEIpIiyiMkI1QjnCPsJEQkoiSuJLokxiTSJN4k6iT2JQIlDiUaJSYlMiU+JUolViWWJdYl4iXuJfomBiYSJh4mlCawJvIm/icKJxYnIicuJzonRidSJ24niieqJ+woCCgiKHYokCi2KNQpBCkiKTopwCnIKnAqeCsCK1orYivcK+Qr8Cv8LAgsFCwgLCwsOCxELFAsXCxoLHQsgCyMLJgspCywLLwsyCzQLNws5CzwLPwtCC0ULSAtLC04LUQtUC1cLWgtdC2ALYwtmC2kLbAtvC5ULlwuaC50LoAujC6YLqQusC68Lsgu1C7gLuwu+C8ELxAvHC8oL2ovci9+L4ovli+iL64vui/GL9Iv3i/qL/YwAjAOMBowJjAyMD4xAjEOMRoxJjEuMToxRjFSMV4xajF2MYIxjjGaMaYyAjIOMhoyJjIyMj4ySjJWMl4yajJ2MoIyjjKaMqYysjK+Msoy1jLiMu4y+jMGMxIzHjMqMzYzQjNOM1ozZjNyM34zijOWM6IzrjO6M8Yz0jPeM+oz9jQCNA40GjQmNDI0PjRKNFY0YjRuNQA1CDWcNaQ2NjY+Nsg21DbsN243dgAAAAAAAQAAA2gAAQCPAwAABwBaAAsAMf+aAAsAM//DAAsANP+uAAsANv9xAB4AHgApAB4AJP/sAB4AJwApAB4ALP/sAB4AMP/sAB4AMf9xAB4AMv/XAB4AM/+FAB4ANP+PAB4ANv9cAB4ANwAUAB4Al/9xAB8AHv/XAB8AMf/XAB8AM//XAB8ANP/sAB8ANf/DAB8ANv+uACEAHv/sACEAM//sACEANP/2ACEANf/hACEANv/DACEAN//sACIAJwApACIANwAhACMAC/+uACMAHv+aACMAJ//DACMAMP/XACQAHv/sACQAMf/XACQAM//sACQANP/2ACQANf/hACQANv/XACQAN//sACgAHgApACgAJP/DACgAJwAUACgALP/DACgAMP/DACgAMv/XACkACv/DACkAIv/XACkAJP/DACkALP/DACkAMP/DACkAMf8zACkAMv/DACkAM/8zACkANP9xACkANv8KACkAl/9cACwAHv/sACwAM//sACwANP/2ACwANf/hACwANv/XAC0AC/+uAC0AHv+uAC0AJ//DAC0ANv/sAC8AIv/XAC8AJP/sAC8AJwAUAC8ALP/sAC8AMP/sAC8AMf/XAC8AMv/sAC8AM//XAC8ANP/XAC8ANv/XADAAM//sADAANf/sADAANv/XADEACv9xADEAC/+aADEADv/sADEAF/+aADEAGP+aADEAGv+aADEAHv9xADEAJP/XADEAJ//XADEALP/XADEAMP/sADEAMQAUADEAMwAUADEANAAUADEANQAUADEAov9xADIAHv/XADIANf/sADMAC//DADMAHv+FADMAIv/sADMAJP/sADMAJ//XADMALP/sADMAMP/sADMAMQAUADMANAAUADMANQApADMANwApADMAov+FADQAC/+uADQAHv+PADQAIv/sADQAJP/2ADQAJ//XADQALP/2ADQAMQAUADQAov97ADUAJP/hADUAJwApADUALP/hADUAMP/sADUAMQAUADUAMv/sADYACv+uADYAC/9xADYAHv9cADYAJP/XADYAJ//XADYALP/XADYAMP/XADYAov9cADcAHgAUADcAJP/sADcALP/sADcANgAbAJcAHv9xAOYAM/+uAOYANP+aAOYANv+aAOcAM/+uAOcANP+aAOcANv+aAAAAHgFuAAEAAAAAAAAA2wAAAAEAAAAAAAEACwDbAAEAAAAAAAIABADmAAEAAAAAAAMAIwDqAAEAAAAAAAQAEAENAAEAAAAAAAUADQEdAAEAAAAAAAYADwEqAAEAAAAAAAgADQE5AAEAAAAAAAkADQFGAAEAAAAAAAoA2wFTAAEAAAAAAAsAEQIuAAEAAAAAAAwAEQI/AAEAAAAAAA4ARwJQAAEAAAAAABAACwKXAAEAAAAAABEABAKiAAMAAQQJAAABtgKmAAMAAQQJAAEAIARcAAMAAQQJAAIACAR8AAMAAQQJAAMARgSEAAMAAQQJAAQAHgTKAAMAAQQJAAUAGgToAAMAAQQJAAYAHgUCAAMAAQQJAAgAGgUgAAMAAQQJAAkAGgU6AAMAAQQJAAoBtgVUAAMAAQQJAAsAIgcKAAMAAQQJAAwAIgcsAAMAAQQJAA4AjgdOAAMAAQQJABAAFgfcAAMAAQQJABEACAfyQmlubmVubGFuZCwgMjAwNiwgRGVzaWduZWQgYnkgTWlrYSBNaXNjaGxlciAvIDIwMDItMjAwNg1BbGwgcmlnaHRzIHJlc2VydmVkLiBUaGlzIHNvZnR3YXJlIG1heSBub3QgYmUgcmVwcm9kdWNlZCwgdXNlZCwgZGlzcGxheWVkLCBtb2RpZmllZCwgZGlzY2xvc2VkIG9yIHRyYW5zZmVycmVkIHdpdGhvdXQgdGhlIGV4cHJlc3Mgd3JpdHRlbiBhcHByb3ZhbCBvZiAoQmlubmVubGFuZCkuWUVFWlkgVFNUQVJCb2xkTWlrYU1pc2NobGVyOiBZRUVaWVRTVEFSLUJvbGQ6IDIwMDJZRUVaWSBUU1RBUiBCb2xkVmVyc2lvbiAxLjAwMllFRVpZVFNUQVItQm9sZE1pa2EgTWlzY2hsZXJNaWthIE1pc2NobGVyQmlubmVubGFuZCwgMjAwNiwgRGVzaWduZWQgYnkgTWlrYSBNaXNjaGxlciAvIDIwMDItMjAwNg1BbGwgcmlnaHRzIHJlc2VydmVkLiBUaGlzIHNvZnR3YXJlIG1heSBub3QgYmUgcmVwcm9kdWNlZCwgdXNlZCwgZGlzcGxheWVkLCBtb2RpZmllZCwgZGlzY2xvc2VkIG9yIHRyYW5zZmVycmVkIHdpdGhvdXQgdGhlIGV4cHJlc3Mgd3JpdHRlbiBhcHByb3ZhbCBvZiAoQmlubmVubGFuZCkud3d3LmJpbm5lbmxhbmQuY2h3d3cuYmlubmVubGFuZC5jaGh0dHA6Ly93d3cuYmlubmVubGFuZC5jaC9tZWRpYS9maWxlcy9iaW5uZW5sYW5kLWxpY2Vuc2luZy1wcmludGZvbnQucGRmWUVFWlkgVFNUQVJCb2xkAEIAaQBuAG4AZQBuAGwAYQBuAGQALAAgADIAMAAwADYALAAgAEQAZQBzAGkAZwBuAGUAZAAgAGIAeQAgAE0AaQBrAGEAIABNAGkAcwBjAGgAbABlAHIAIAAvACAAMgAwADAAMgAtADIAMAAwADYADQBBAGwAbAAgAHIAaQBnAGgAdABzACAAcgBlAHMAZQByAHYAZQBkAC4AIABUAGgAaQBzACAAcwBvAGYAdAB3AGEAcgBlACAAbQBhAHkAIABuAG8AdAAgAGIAZQAgAHIAZQBwAHIAbwBkAHUAYwBlAGQALAAgAHUAcwBlAGQALAAgAGQAaQBzAHAAbABhAHkAZQBkACwAIABtAG8AZABpAGYAaQBlAGQALAAgAGQAaQBzAGMAbABvAHMAZQBkACAAbwByACAAdAByAGEAbgBzAGYAZQByAHIAZQBkACAAdwBpAHQAaABvAHUAdAAgAHQAaABlACAAZQB4AHAAcgBlAHMAcwAgAHcAcgBpAHQAdABlAG4AIABhAHAAcAByAG8AdgBhAGwAIABvAGYAIAAoAEIAaQBuAG4AZQBuAGwAYQBuAGQAKQAuAFkARQBFAFoAWQAgAFQAUwBUAEEAUgAgAEIAbwBsAGQAQgBvAGwAZABNAGkAawBhAE0AaQBzAGMAaABsAGUAcgA6ACAAWQBFAEUAWgBZAFQAUwBUAEEAUgAtAEIAbwBsAGQAOgAgADIAMAAwADIAWQBFAEUAWgBZAFQAUwBUAEEAUgAtAEIAbwBsAGQAVgBlAHIAcwBpAG8AbgAgADEALgAwADAAMgBZAEUARQBaAFkAVABTAFQAQQBSAC0AQgBvAGwAZABNAGkAawBhACAATQBpAHMAYwBoAGwAZQByAE0AaQBrAGEAIABNAGkAcwBjAGgAbABlAHIAQgBpAG4AbgBlAG4AbABhAG4AZAAsACAAMgAwADAANgAsACAARABlAHMAaQBnAG4AZQBkACAAYgB5ACAATQBpAGsAYQAgAE0AaQBzAGMAaABsAGUAcgAgAC8AIAAyADAAMAAyAC0AMgAwADAANgANAEEAbABsACAAcgBpAGcAaAB0AHMAIAByAGUAcwBlAHIAdgBlAGQALgAgAFQAaABpAHMAIABzAG8AZgB0AHcAYQByAGUAIABtAGEAeQAgAG4AbwB0ACAAYgBlACAAcgBlAHAAcgBvAGQAdQBjAGUAZAAsACAAdQBzAGUAZAAsACAAZABpAHMAcABsAGEAeQBlAGQALAAgAG0AbwBkAGkAZgBpAGUAZAAsACAAZABpAHMAYwBsAG8AcwBlAGQAIABvAHIAIAB0AHIAYQBuAHMAZgBlAHIAcgBlAGQAIAB3AGkAdABoAG8AdQB0ACAAdABoAGUAIABlAHgAcAByAGUAcwBzACAAdwByAGkAdAB0AGUAbgAgAGEAcABwAHIAbwB2AGEAbAAgAG8AZgAgACgAQgBpAG4AbgBlAG4AbABhAG4AZAApAC4AdwB3AHcALgBiAGkAbgBuAGUAbgBsAGEAbgBkAC4AYwBoAHcAdwB3AC4AYgBpAG4AbgBlAG4AbABhAG4AZAAuAGMAaABoAHQAdABwADoALwAvAHcAdwB3AC4AYgBpAG4AbgBlAG4AbABhAG4AZAAuAGMAaAAvAG0AZQBkAGkAYQAvAGYAaQBsAGUAcwAvAGIAaQBuAG4AZQBuAGwAYQBuAGQALQBsAGkAYwBlAG4AcwBpAG4AZwAtAHAAcgBpAG4AdABmAG8AbgB0AC4AcABkAGYAWQBFAEUAWgBZACAAVABTAFQAQQBSAEIAbwBsAGQAAgAAAAAAAP8XAGgAAAAAAAAAAAAAAAAAAAAAAAAAAAFIAAAAAwAEAAcACAAJAAsADAAOAA8AEAARABIAEwAUABUAFgAXABgAGQAaABsAHAAdAB4AHwAgACEAIgAjACQAJQAmACcAKAApACoAKwAsAC0ALgAvADAAMQAyADMANAA1ADYANwA4ADkAOgA7ADwAPQBDAIUAigCLAIwAjQCpAKoArQDHAMgAyQDLAMwAzQDPANAA0QDTANQA1QDWANgBAgBlAPQA9QD2APAAlgBCALIAswBEAEUARgBHAEgASQBKAEsATABNAE4ATwBQAFEAUgBTAFQAVQBWAFcAWABZAFoAWwBcAF0AagBrAGkAcQB/AIAAfgB6AHsAeQB1AHYAdABwAHIBAwEEAG4AcwBkAG8AfACBAN0A3gCOAGIAYwBnAGgAbADKAM4AdwC2ALcACgAFAL4AvwDZAQUA2wDcAN8A4QDgAJAAoACwALEA6QDiAOMA7QDuAQYBBwEIAK4BCQEKAQsBDABtAQ0A/QD/AQ4BDwD+AQABEAERARIBEwEUARUBFgEXARgBGQEaARsBHAEdAR4BHwD4ASABIQEiAPkBIwEkASUBJgEnASgBKQEqASsBLAEtAS4BLwEwATEBMgEzATQBNQE2ATcBOAE5AToBOwE8AT0BPgE/AUABQQFCAUMBRABmAHgBRQFGAUcBSAFJAJEBSgCvAUsAoQFMAH0BTQFOAU8BUADkAPsBUQFSAVMBVAFVAVYA5QD8AVcBWAFZAVoBWwFcAV0BXgFfAWABYQFiAWMBZAFlAWYBZwFoAWkBagFrAWwBbQFuAW8BcAFxAOsBcgC7AXMBdADmAXUA7AF2ALoBdwF4AOcBeQF6AXsBfAF9AX4BfwGAAYEBggGDAYQBhQDqAYYBhwGIAYkERXVybwVaLmFsdAV6LmFsdAZtYWNyb24GQWJyZXZlB0FtYWNyb24HQW9nb25lawdBRWFjdXRlBmFicmV2ZQdhbWFjcm9uB2FvZ29uZWsHYWVhY3V0ZQtDY2lyY3VtZmxleApDZG90YWNjZW50C2NjaXJjdW1mbGV4CmNkb3RhY2NlbnQGRGNhcm9uBkRjcm9hdAZkY2Fyb24GZGNyb2F0BkVicmV2ZQZFY2Fyb24KRWRvdGFjY2VudAdFbWFjcm9uB0VvZ29uZWsGZWJyZXZlBmVjYXJvbgplZG90YWNjZW50B2VtYWNyb24HZW9nb25lawtHY2lyY3VtZmxleAxHY29tbWFhY2NlbnQKR2RvdGFjY2VudAtnY2lyY3VtZmxleAxnY29tbWFhY2NlbnQKZ2RvdGFjY2VudARIYmFyBGhiYXILSGNpcmN1bWZsZXgLaGNpcmN1bWZsZXgGSWJyZXZlCklkb3RhY2NlbnQHSW1hY3JvbgdJb2dvbmVrBkl0aWxkZQtKY2lyY3VtZmxleAZpYnJldmUHaW1hY3Jvbgdpb2dvbmVrBml0aWxkZQtqY2lyY3VtZmxleAxLY29tbWFhY2NlbnQMa2NvbW1hYWNjZW50BkxhY3V0ZQZsYWN1dGUGTGNhcm9uBmxjYXJvbgxsY29tbWFhY2NlbnQEbGRvdARMZG90DExjb21tYWFjY2VudAZOYWN1dGUGbmFjdXRlBk5jYXJvbgZuY2Fyb24MTmNvbW1hYWNjZW50DG5jb21tYWFjY2VudAZPYnJldmUGb2JyZXZlDU9odW5nYXJ1bWxhdXQNb2h1bmdhcnVtbGF1dAdPbWFjcm9uC09zbGFzaGFjdXRlB29tYWNyb24Lb3NsYXNoYWN1dGUGUmFjdXRlBlJjYXJvbgxSY29tbWFhY2NlbnQGU2FjdXRlC1NjaXJjdW1mbGV4DFNjb21tYWFjY2VudARUYmFyBlRjYXJvbgxUY29tbWFhY2NlbnQGc2FjdXRlC3NjaXJjdW1mbGV4DHNjb21tYWFjY2VudAR0YmFy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) format('truetype');
      font-weight: bold;
      font-style: normal;
    }
    h1 { font-family: yeezy-tstar-strong; }
    h2 { font-family: yeezy-tstar-strong; }
    h3 { font-family: yeezy-tstar-strong; }
    h4 { font-family: yeezy-tstar-strong; }
    p  { font-family: yeezy-tstar-strong; }
    a  { font-family: yeezy-tstar-strong; }
    td { font-family: yeezy-tstar-strong; }
    #headers {
    font-family: yeezy-tstar-strong;
    background-color: #505050;
    color: #ffffff;
    vertical-align: middle;
    }
    body {
      background:
      url(data:image/png;base64,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)
      repeat
      left center;
    }

    div {
        color: #1B232F;
        font-family: Verdana, Arial, sans-serif;
        font-size: 18px;
        font-weight: bold;
        text-decoration: none;
    }

    </style>
  </head>
  <?php
    $useragents=array(
      "Mozilla/5.0 (iPhone; CPU iPhone OS 8_0 like Mac OS X) AppleWebKit/600.1.3 (KHTML, like Gecko) Version/8.0 Mobile/12A4345d Safari/600.1.4",
      "Mozilla/5.0 (iPhone; CPU iPhone OS 8_0 like Mac OS X) AppleWebKit/600.1.3 (KHTML, like Gecko) Version/8.0 Mobile/12A4345d Safari/600.1.4",
      "Mozilla/5.0 (iPhone; CPU iPhone OS 7_0 like Mac OS X; en-us) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A465 Safari/9537.53",
      "Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_2_1 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148 Safari/6533.18.5",
      "Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_2_1 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148 Safari/6533.18.5",
      "Mozilla/5.0 (iPad; CPU OS 7_0 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A465 Safari/9537.53",
      "Mozilla/5.0 (iPad; CPU OS 4_3_5 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8L1 Safari/6533.18.5",
      "Mozilla/5.0 (Linux; U; en-us; KFAPWI Build/JDQ39) AppleWebKit/535.19 (KHTML, like Gecko) Silk/3.13 Safari/535.19 Silk-Accelerated=true",
      "Mozilla/5.0 (Linux; U; en-us; KFTHWI Build/JDQ39) AppleWebKit/535.19 (KHTML, like Gecko) Silk/3.13 Safari/535.19 Silk-Accelerated=true",
      "Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_3; en-us; Silk/1.0.141.16-Gen4_11004310) AppleWebkit/533.16 (KHTML, like Gecko) Version/5.0 Safari/533.16 Silk-Accelerated=true",
      "Mozilla/5.0 (Linux; U; Android 2.3.4; en-us; Nexus S Build/GRJ22) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
      "Mozilla/5.0 (Linux; Android 4.3; Nexus 7 Build/JSS15Q) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.72 Safari/537.36",
      "Mozilla/5.0 (Linux; Android 4.2.1; en-us; Nexus 5 Build/JOP40D) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.166 Mobile Safari/535.19",
      "Mozilla/5.0 (BB10; Touch) AppleWebKit/537.10+ (KHTML, like Gecko) Version/10.0.9.2372 Mobile Safari/537.10+",
      "Mozilla/5.0 (Linux; Android 4.3; Nexus 10 Build/JSS15Q) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.72 Safari/537.36",
      "Mozilla/5.0 (Linux; U; Android 2.3; en-us; SAMSUNG-SGH-I717 Build/GINGERBREAD) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
      "Mozilla/5.0 (Linux; U; Android 4.3; en-us; SM-N900T Build/JSS15J) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30",
      "Mozilla/5.0 (Linux; U; Android 4.0; en-us; GT-I9300 Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30",
      "Mozilla/5.0 (Linux; Android 4.2.2; GT-I9505 Build/JDQ39) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.59 Mobile Safari/537.36",
      "Mozilla/5.0 (Linux; U; Android 2.2; en-us; SCH-I800 Build/FROYO) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
      "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36");
    $marketsList=[];

    $marketsList['AE']='en_AE';
    $marketsList['AR']='es_AR';
    $marketsList['AT']='de_AT';
    $marketsList['AU']='en_AU';
    $marketsList['BE']='fr_BE';
    $marketsList['BH']='en_BH';
    $marketsList['BR']='pt_BR';
    $marketsList['CA']='en_CA';
    $marketsList['CF']='fr_CA';
    $marketsList['CH']='de_CH';
    $marketsList['CL']='es_CL';
    $marketsList['CN']='zh_CN';
    $marketsList['CO']='es_CO';
    $marketsList['CZ']='cz_CZ';
    $marketsList['DE']='de_DE';
    $marketsList['DK']='da_DK';
    $marketsList['EE']='et_EE';
    $marketsList['ES']='es_ES';
    $marketsList['FI']='fi_FI';
    $marketsList['FR']='fr_FR';
    $marketsList['GB']='en_GB';
    $marketsList['GR']='en_GR';
    $marketsList['HK']='zh_HK';
    $marketsList['HU']='hu_HU';
    $marketsList['ID']='id_ID';
    $marketsList['IE']='en_IE';
    $marketsList['IN']='en_IN';
    $marketsList['IT']='it_IT';
    $marketsList['JP']='ja_JP';
    $marketsList['KR']='ko_KR';
    $marketsList['KW']='ar_KW';
    $marketsList['MX']='es_MX';
    $marketsList['MY']='en_MY';
    $marketsList['NG']='en_NG';
    $marketsList['NL']='nl_NL';
    $marketsList['NO']='no_NO';
    $marketsList['NZ']='en_NZ';
    $marketsList['OM']='en_OM';
    $marketsList['PE']='es_PE';
    $marketsList['PH']='en_PH';
    $marketsList['PL']='pl_PL';
    $marketsList['PT']='en_PT';
    $marketsList['QA']='en_QA';
    $marketsList['RU']='ru_RU';
    $marketsList['SA']='en_SA';
    $marketsList['SE']='sv_SE';
    $marketsList['SG']='en_SG';
    $marketsList['SK']='sk_SK';
    $marketsList['TH']='th_TH';
    $marketsList['TR']='tr_TR';
    $marketsList['TW']='zh_TW';
    $marketsList['US']='en_US';
    $marketsList['VE']='es_VE';
    $marketsList['VN']='vi_VN';
    $marketsList['ZA']='en_ZA';

    $marketDomainList=[];
    $marketDomainList["AT"]="adidas.at";
    $marketDomainList["AU"]="adidas.com.au";
    $marketDomainList["BE"]="adidas.be";
    $marketDomainList["BR"]="adidas.com.br";
    $marketDomainList["CA"]="adidas.ca";
    $marketDomainList["CF"]="adidas.ca";
    $marketDomainList["CH"]="adidas.ch";
    $marketDomainList["CL"]="adidas.cl";
    $marketDomainList["CN"]="adidas.cn";
    $marketDomainList["CO"]="adidas.co";
    $marketDomainList["CZ"]="adidas.cz";
    $marketDomainList["DE"]="adidas.de";
    $marketDomainList["DK"]="adidas.dk";
    $marketDomainList["EE"]="baltics.adidas.com";
    $marketDomainList["ES"]="adidas.es";
    $marketDomainList["FI"]="adidas.fi";
    $marketDomainList["FR"]="adidas.fr";
    $marketDomainList["GB"]="adidas.co.uk";
    $marketDomainList["GR"]="adidas.gr";
    $marketDomainList["HK"]="adidas.com.hk";
    $marketDomainList["HU"]="adidas.hu";
    $marketDomainList["IE"]="adidas.ie";
    $marketDomainList["ID"]="adidas.co.id";
    $marketDomainList["IN"]="adidas.co.in";
    $marketDomainList["IT"]="adidas.it";
    $marketDomainList["JP"]="japan.adidas.com";
    $marketDomainList["KR"]="adidas.co.kr";
    $marketDomainList["KW"]="mena.adidas.com";
    $marketDomainList["MX"]="adidas.mx";
    $marketDomainList["MY"]="adidas.com.my";
    $marketDomainList["NG"]="global.adidas.com";
    $marketDomainList["NL"]="adidas.nl";
    $marketDomainList["NO"]="adidas.no";
    $marketDomainList["NZ"]="adidas.co.nz";
    $marketDomainList["OM"]="adidas.com.om";
    $marketDomainList["PE"]="adidas.pe";
    $marketDomainList["PH"]="adidas.com.ph";
    $marketDomainList["PL"]="adidas.pl";
    $marketDomainList["PT"]="adidas.pt";
    $marketDomainList["QA"]="adidas.com.qa";
    $marketDomainList["RU"]="adidas.ru";
    $marketDomainList["SE"]="adidas.se";
    $marketDomainList["SG"]="adidas.com.sg";
    $marketDomainList["SK"]="adidas.sk";
    $marketDomainList['TH']='adidas.co.th';
    $marketDomainList['TR']='adidas.com.tr';
    $marketDomainList['TW']='adidas.com.tw';
    $marketDomainList["US"]="adidas.com";
    $marketDomainList['VE']='latin-america.adidas.com';
    $marketDomainList['VN']='adidas.com.vn';
    $marketDomainList['ZA']='adidas.co.za';

    $sizes=[];
    $readableSizes=[];

    $currentSize=4;
    for ($x = 530; $x <= 810; $x=$x+10)
    {
      array_push($sizes, $x);
      $readableSizes[$x]=$currentSize;
      $currentSize=$currentSize+0.5;
    }

    function debugPrint($string)
    {
      echo "<pre>\n";
      echo $string."\n";
      echo "</pre>\n";
    }

    function printInventoryTable($sku,$clientId,$sitekey,$locale,$productMasterId,$productName,$productCollection,$productColor,$productInventory,$productPrice,$clientSizes,$clientCount,$stockSizes,$stockCount,$atcURL,$timer,$duplicate,$gcaptcha)
    {
      global $sizes;
      global $readableSizes;
      global $actionURL;
      $cartURL=str_replace("http://","https://",$atcURL);
      $cartURL=str_replace("Cart-MiniAddProduct","Cart-Show",$cartURL);

      echo"      <h2>"."\n";
      echo"        <table>"."\n";
      echo"          <tr>"."\n";
      echo"            <form action='".$actionURL."' method='get'>"."\n";
      echo"              <td>"."\n";
      echo"                <input type='submit' value='Main Page' name='submit' id='submit'/>"."\n";
      echo"              </td>"."\n";
      echo"            </form>"."\n";
      echo"            <form action='".$actionURL."' method='post'>"."\n";
      echo"              <td>"."\n";
      echo"                <input type='hidden' value='" . $sku . "' name='sku' id='sku'/>"."\n";
      echo"                <input type='hidden' value='" . $clientId . "' name='clientId' id='clientId'/>"."\n";
      echo"                <input type='hidden' value='" . $sitekey . "' name='sitekey' id='sitekey'/>"."\n";
      echo"                <input type='hidden' value='" . $locale . "' name='locale' id='locale'/>"."\n";
      echo"                <input type='hidden' value='" . $duplicate . "' name='locale' id='duplicate'/>"."\n";
      echo"                <input type='hidden' value='loadParametersPage' name='gotoPage' id='gotoPage'/>"."\n";
      echo"                <input type='submit' value='Change Parameters' name='submit' id='submit'/>"."\n";
      echo"              </td>"."\n";
      echo"            </form>"."\n";
      echo"            <form action='".$actionURL."' method='post'>"."\n";
      echo"              <td>"."\n";
      echo"                <input type='hidden' value='" . $sku . "' name='sku' id='sku'/>"."\n";
      echo"                <input type='hidden' value='" . $clientId . "' name='clientId' id='clientId'/>"."\n";
      echo"                <input type='hidden' value='" . $sitekey . "' name='sitekey' id='sitekey'/>"."\n";
      echo"                <input type='hidden' value='" . $locale . "' name='locale' id='locale'/>"."\n";
      echo"                <input type='hidden' value='" . $duplicate . "' name='duplicate' id='duplicate'/>"."\n";
      echo"                <input type='hidden' value='loadInventoryPage' name='gotoPage' id='gotoPage'/>"."\n";
      echo"                <input type='submit' value='Refresh Inventory' name='submit' id='submit'/>"."\n";
      echo"              </td>"."\n";
      echo"            </form>"."\n";
      echo"              <td>"."\n";
      echo"                <a target='_blank' href='".$cartURL."'> [ View Cart ] </a>"."\n";
      echo"              </td>"."\n";
      echo"          </tr>"."\n";
      echo"        </table>"."\n";
      echo"      </h2>"."\n";
      echo""."\n";
      echo"      <h2>"."\n";
      echo"        <table>"."\n";
      echo"          <tr><td id='headers'><b>Locale         </b></td><td>" . $locale ."                </td></tr>"."\n";
      echo"          <tr><td id='headers'><b>MasterId       </b></td><td>" . $sku ."       </td></tr>"."\n";
      echo"          <tr><td id='headers'><b>Name           </b></td><td>" . $productName ."           </td></tr>"."\n";
      echo"          <tr><td id='headers'><b>Collection     </b></td><td>" . $productCollection ."     </td></tr>"."\n";
      echo"          <tr><td id='headers'><b>Color          </b></td><td>" . $productColor ."          </td></tr>"."\n";
      echo"          <tr><td id='headers'><b>Inventory      </b></td><td>" . $productInventory ."      </td></tr>"."\n";
      echo"          <tr><td id='headers'><b>Price          </b></td><td>" . $productPrice . ' ' . $locale ." Currency</td></tr>"."\n";
      echo"        </table>"."\n";
      echo"      </h2>"."\n";
      echo""."\n";
      echo"      <h2>"."\n";
      echo"        <table>"."\n";
      echo"          <tr>"."\n";
      echo"            <td>"."\n";
      echo"              <form action='".$actionURL."' method='post'>"."\n";
      echo"                <fieldset>"."\n";
      echo"                  <h2>Current Captcha SITE-KEY<br></h2>"."\n";
      echo"                  <pre>" . $sitekey ."</pre>"."\n";
      echo"                  <h2>Google  Captcha<br>"."\n";
      echo"                    <div class='g-recaptcha' data-sitekey='" . $sitekey . "' ></div>"."\n";
      echo"                    <script type='text/javascript' src='https://www.google.com/recaptcha/api.js'></script>"."\n";
      echo"                  </h2>"."\n";
      echo"                  <p>"."\n";
      echo"                    <input type='hidden' size='50' value='" . $sitekey . "' name='sitekey' id='sitekey'/>"."\n";
      echo"                    <input type='hidden' value='" . $locale . "' name='locale' id='locale'/>"."\n";
      echo"                    <input type='hidden' value='" . $duplicate . "' name='locale' id='duplicate'/>"."\n";
      echo"                    <input type='hidden' value='setGCaptchaTokenPage' name='gotoPage' id='gotoPage'/>"."\n";
      echo"                    <input type='submit' value='Transfer Google Captcha Token' name='submit' id='submit'/>"."\n";
      echo"                  </p>"."\n";
      echo"                </fieldset>"."\n";
      echo"              </form>"."\n";
      echo"            </td>"."\n";
      echo"            <td valign='top'>"."\n";
      echo"              <fieldset>"."\n";
      echo"                <h2>Current g-captcha Response<br>"."\n";
                           if ( (isset($_POST['g-recaptcha-response'])) && (strlen($_POST['g-recaptcha-response'])>0) )
                           {
                             $gcaptcha=$_POST['g-recaptcha-response'];
                           }
                           else
                           {
                             $gcaptcha="";
                           }
      echo"                  <textarea name='gcaptcha' id='gcaptcha' cols='50' rows='2'>" . $gcaptcha . "</textarea>"."\n";
      echo"                  <br>"."\n";
                           if ($timer)
                           {
      echo"                  Token will expire at <font color='red'><script>document.write(getCookie('captchaExpiration'));</script></font>"."\n";
      echo"                  <br>You can only use it for a single ATC click."."\n";
                           }
      echo"                </h2>"."\n";
      echo"                <h2>Link to copy for injection<br>"."\n";
      echo"                  <textarea name='inject' id='inject' cols='50' rows='5'></textarea>"."\n";
      echo"                  <br>"."\n";
      echo"                </h2>"."\n";
      echo"                <a target='_blank' href='".$cartURL."'> [ View Cart ] </a>"."\n";
      echo"              </fieldset>"."\n";
      echo"            </td>"."\n";
      echo"          </tr>"."\n";
      echo"        </table>"."\n";
      echo"      </h2>"."\n";
      echo""."\n";
      echo"      <h2>"."\n";
      echo"        <table id=\"stocktable\">"."\n";
      echo"          <tr>"."\n";
      echo"            <th id='headers'>Product Id</th>"."\n";
      echo"            <th id='headers'>GetVariant<br>Stock</th>"."\n";
      echo"            <th id='headers'>Client<br>Stock</th>"."\n";
      echo"            <th id='headers'>Size<br>(US)</th>"."\n";
      echo"            <th id='headers'>INJECTION<br>"."\n";
                       if (strlen($gcaptcha)<1)
                       {
      echo"                <br><font color='red'>CAPTCHA<br>UNSOLVED</font>"."\n";
                       }
                       else
                       {
      echo"                <br><font color='green'>CAPTCHA<br>SOLVED</font>"."\n";
                       }
      echo"            </th>"."\n";
      echo"            <th id='headers'>ATC<br>via<br>BD<br>"."\n";
                       if (strlen($gcaptcha)<1)
                       {
      echo"                <br><font color='red'>CAPTCHA<br>UNSOLVED</font>"."\n";
                       }
                       else
                       {
      echo"                <br><font color='green'>CAPTCHA<br>SOLVED</font>"."\n";
                       }
      echo"            </th>"."\n";
      echo"            <th id='headers'>ATC<br>+<br>CAPATCHA DUP<br>"."\n";
                       if (strlen($gcaptcha)<1)
                       {
      echo"                <br><font color='red'>CAPTCHA<br>UNSOLVED</font>"."\n";
                       }
                       else
                       {
      echo"                <br><font color='green'>CAPTCHA<br>SOLVED</font>"."\n";
                       }
      echo"            </th>"."\n";
      echo"          </tr>"."\n";
      echo""."\n";
                    $sizeIterator=[];
                    //We check which size listing is the largest and iterate using it.
                    if (sizeof($clientSizes) != sizeof($stockSizes))
                    {
                      if (sizeof($clientSizes) > sizeof($stockSizes))
                      {
                        $sizeIterator=$clientSizes;
                      }
                      else
                      {
                        $sizeIterator=$stockSizes;
                      }
                    }
                    //Else - both lists are of the same size. So lets just use the client version for iteration.
                    else
                    {
                      $sizeIterator=$clientSizes;
                    }
                    //If there is no sensible response from either endpoints
                    //Then lets make a fake list to iterate so we can produce ATC links and buttons.
                    if ((sizeof($clientSizes) == 0) &&  (sizeof($stockSizes) == 0))
                    {
                      foreach($sizes as $size)
                      {
                        //$sizeIterator[$sku."_".$size]=$size;
                        $sizeIterator[$sku."_".$size]=$readableSizes[$size];
                      }
                    }
      echo""."\n";

                    foreach($sizeIterator as $pid=>$size)
                    {
      echo"          <tr>"."\n";
      echo"            <td>"."\n";
      echo"                " . $pid ."\n";
      echo"            </td>"."\n";

                      if (@$stockCount[$pid] > 0)
                      {
      echo"                <td><center><b><font color='green'>" . @$stockCount[$pid] . "</font></b></center></td>"."\n";
                      }
                      else
                      {
      echo"                <td><center><b><font color='red'>" . @$stockCount[$pid] . "</font></b></center></td>"."\n";
                      }
                      if (@$clientCount[$pid] > 0)
                      {
      echo"                <td><center><b><font color='green'>" . @$clientCount[$pid] . "</font></b></center></td>"."\n";
                      }
                      else
                      {
      echo"                <td><center><b><font color='red'>" . @$clientCount[$pid] . "</font></b></center></td>"."\n";
                      }
      echo"            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $size . "</td>"."\n";

      $backDoorADCURL=$atcURL."?pid=".$pid."&masterPid=".$sku."&ajax=true";

      if (isset($gcaptcha))
      {
        if (strlen($gcaptcha) > 50)
        {
          $backDoorADCURL=$atcURL."?pid=".$pid."&masterPid=".$sku."&ajax=true&g-recaptcha-response=".$gcaptcha;
        }
      }
      echo"            <form id='injection' action='".$atcURL."' method='post' name='addProductForm' target='_blank'>"."\n";
//    echo"            <form id='injection' action='".$atcURL."' method='post' name='addProductForm' target='_self'>"."\n";
      echo"            <td>"."\n";
      if (isset($gcaptcha))
      {
        if (strlen($gcaptcha) > 50)
        {
          echo"              <input type='hidden' name='g-recaptcha-response' value='".$gcaptcha."'>"."\n";
        }
      }
      echo"              <input type='hidden' name='pid' value='".$pid."'>"."\n";
      echo"              <input type='hidden' name='masterPid' value='".$sku."'>"."\n";
      echo"              <input type='hidden' name='Quantity' value='1'>"."\n";
      echo"              <input type='hidden' name='request' value='ajax'>"."\n";
      echo"              <input type='hidden' name='responseformat' value='json'>"."\n";
      echo"              <input type='hidden' name='sessionSelectedStoreID' value='null'>"."\n";
      echo"              <input type='hidden' name='layer' value='Add To Bag overlay'>"."\n";
      echo"              <button name='add-to-cart-button'><span>Fuck Niketalk</span></button>"."\n";
      echo"            </td>"."\n";
      echo"            </form>"."\n";

      echo"            <form id='notify' action='".$atcURL."' method='post' name='addProductForm' target='_blank'>"."\n";
//    echo"            <form id='notify' action='".$atcURL."' method='post' name='addProductForm' target='_self'>"."\n";
      echo"            <td>"."\n";
      if (isset($gcaptcha))
      {
        if (strlen($gcaptcha) > 50)
        {
          echo"              <input type='hidden' name='g-recaptcha-response' value='".$gcaptcha."'>"."\n";
        }
      }
      echo"              <input type='hidden' name='pid' value='".$pid."'>"."\n";
      echo"              <input type='hidden' name='masterPid' value='".$sku."'>"."\n";
      echo"              <input type='hidden' name='Quantity' value='1'>"."\n";
      echo"              <input type='hidden' name='request' value='ajax'>"."\n";
      echo"              <input type='hidden' name='responseformat' value='json'>"."\n";
      echo"              <input type='hidden' name='sessionSelectedStoreID' value='null'>"."\n";
      echo"              <button name='add-to-cart-button'><span>Fuck Niketalk</span></button>"."\n";
      echo"            </td>"."\n";
      echo"            </form>"."\n";

      echo"            <form id='notify' action='".$atcURL."?clientId=".$clientId."' method='post' target='_blank'>"."\n";
//    echo"            <form id='notify' action='".$atcURL."?clientId=".$clientId."' method='post' target='_self'>"."\n";
      echo"            <td>"."\n";

      if (isset($gcaptcha))
      {
        if (strlen($gcaptcha) > 50)
        {
          echo"              <input type='hidden' name='g-recaptcha-response' value='".$gcaptcha."'>"."\n";
          echo"              <input type='hidden' name='".$duplicate."' value='".$gcaptcha."'>"."\n";
        }
      }
      echo"              <input type='hidden' name='pid' value='".$pid."'>"."\n";
      echo"              <input type='hidden' name='Quantity' value='1'>"."\n";
      echo"              <input type='hidden' name='request' value='ajax'>"."\n";
      echo"              <input type='hidden' name='responseformat' value='json'>"."\n";
      echo"              <input type='hidden' name='sessionSelectedStoreID' value='null'>"."\n";
      echo"              <center><input type='submit' name='submit_captcha' value='ADD TO BAG'></center>"."\n";
      echo"            </td>"."\n";
      echo"            </form>"."\n";

      echo"          </tr>"."\n";
                    }
      echo"        </table>"."\n";
      echo'      <script>
                  $("form#notify").submit(function(event) {
                    try
                    {
                      var lastBasketCount=getCookie("userBasketCount");
                    }
                    catch(err)
                    {
                      var lastBasketCount=0;
                    }
                    var objArray=$(event.target).serializeArray();
                    var dataArray={};
                    for (var i = 0, l = objArray.length; i < l; i++) {
                        dataArray[objArray[i].name] = objArray[i].value;
                    }
                    console.log(dataArray);
                    event.preventDefault();
                    $.ajax({
                      url: event.target.action,
                      data: $(event.target).serialize(),
                      method: "POST",
                      crossDomain: true,
                      contentType: "application/x-www-form-urlencoded",
                      xhrFields: {
                          withCredentials: true
                      },
                      complete: function(data, status, xhr) {
                        var currentBasketCount=getCookie("userBasketCount");
                        if (currentBasketCount > lastBasketCount)
                        {
                          $.notify("Added "+dataArray["pid"]+" to cart!","success");
                          $.notify(currentBasketCount+" item(s) in cart.","success");
                        }
                        else
                        {
                          $.notify("Chicken Butt","error");
                        }
                        $("textarea#gcaptcha").val("Token used. Solve another CAPTCHA");
                      }
                    });
                  });
                 </script>';
      echo'      <script>
                  $("form#injection").submit(function(event) {
                    event.preventDefault();
                    var objArray=$(event.target).serializeArray();
                    var dataArray={};
                    for (var i = 0, l = objArray.length; i < l; i++) {
                        dataArray[objArray[i].name] = objArray[i].value;
                    }
                    var atcURL="'.$atcURL.'"+"?pid="+dataArray["pid"]+"&masterPid="+dataArray["masterPid"]+"&ajax=true&g-recaptcha-response="+dataArray["g-recaptcha-response"];
                    $("textarea#inject").val(atcURL);
                    $("textarea#gcaptcha").val("Token used. Solve another CAPTCHA");
                  });
                 </script>';
      echo"      </h2>";
    }

  ?>
  <body onload="checkCookie()">
    <?php
      //SKU is obtained from cookies
      @$sku=$_COOKIE['d3stripesSku'];
      //Main page Refresh is obtained from cookies
      @$refreshed=$_COOKIE['d3stripesRefresh'];
      //Client ID is obtained from cookies
      @$clientId=$_COOKIE['d3stripesClientId'];
      //Captcha site-key is obtained from cookies
      @$sitekey=$_COOKIE['d3stripesSiteKey'];
      //Locale is obtained from cookies
      @$locale=$_COOKIE['d3stripesLocale'];
      //Curl Timeout
      @$timeout=$_COOKIE['d3stripesTimeOut'];
      //captcha duplicate fieldname
      @$duplicate=$_COOKIE['d3stripesDuplicate'];
    ?>
    <!-- Check if user refreshed their brower so cookies can stick -->
    <?php if (!isset($refreshed)): ?>
      <table width="100%">
        <tr>
          <td>
            <fieldset>
              <h2><font color="red">Refresh your browser again in order for default cookies to stick.</font></h2>
            </fieldset>
          </td>
        </tr>
      </table>
    <?php endif; ?>
    <?php if ( (isset($_POST['gotoPage'])) && (@$_POST['gotoPage'] == 'loadInventoryPage')): ?>

      <?php
        $sku=$_POST['sku'];
        if ( ($sku == "XX####") )
        {
          echo '<h2>Invalid Sku!</h2>';
        }
        if ( (isset($_POST['gcaptcha'])) && (strlen($_POST['gcaptcha']) > 0))
        {
          $gcaptcha=$_POST['gcaptcha'];
        }
        else
        {
          $gcaptcha="";
        }
        $clientId=$_POST['clientId'];
        $locale=$_POST['locale'];
        $duplicate=$_POST['duplicate'];

        if ($locale == "PT")
        {
          $baseADCURL="http://www.".$marketDomainList[$locale]."/on/demandware.store/Sites-adidas-"."MLT"."-Site/".$marketsList[$locale];
        }
        else
        {
          $baseADCURL="http://www.".$marketDomainList[$locale]."/on/demandware.store/Sites-adidas-".$locale."-Site/".$marketsList[$locale];
        }
        $atcURL=$baseADCURL."/Cart-MiniAddProduct";
        $urlVariantStock=$baseADCURL."/Product-GetVariants?pid=".$sku;

        $skus="";
        foreach ($sizes as $size)
        {
          $skus=$skus.$sku."_".$size.",";
        }

        //Thanks to @PythonKicks/TWTR for the logical fix below for CANADA and MEXICO
        if (($locale == "US")||($locale == "CA")||($locale == "MX"))
        {
          $urlClientStock="http://production-us-adidasgroup.demandware.net/s/adidas-".$locale."/dw/shop/v15_6/products/(".$skus.")?client_id=".$clientId."&expand=availability,variations,prices";
        }
        elseif ($locale == "PT")
        {
          $urlClientStock="http://production-store-adidasgroup.demandware.net/s/adidas-"."MLT"."/dw/shop/v15_6/products/(".$skus.")?client_id=".$clientId."&expand=availability,variations,prices";
        }
        else
        {
          $urlClientStock="http://production.store.adidasgroup.demandware.net/s/adidas-".$locale."/dw/shop/v15_6/products/(".$skus.")?client_id=".$clientId."&expand=availability,variations,prices";
        }

        //Randomize our User-Agent
        $useragent=$useragents[rand()%sizeof($useragents)];

        $curl = curl_init();
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl,CURLINFO_HEADER_OUT, 1);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl,CURLOPT_USERAGENT, $useragent);
        curl_setopt($curl,CURLOPT_HTTPHEADER, array("User-Agent:".$useragent));
        curl_setopt($curl,CURLOPT_CONNECTTIMEOUT , $timeout);
        curl_setopt($curl,CURLOPT_FRESH_CONNECT , True);

        $stockCount=[];
        $stockSizes=[];
        $clientCount=[];
        $clientSizes=[];

        $productId="";
        $productInventory="";
        $productMasterId="";
        $productName="";
        $productPrice="";
        $productCollection="";
        $productColor="";

      ?>

      <?php
        function getInventoryVariant()
        {
          global $curl;
          global $urlVariantStock;
          global $stockCount;
          global $stockSizes;

          curl_setopt($curl,CURLOPT_URL, $urlVariantStock);
          $response = curl_exec($curl) or die(curl_error($curl));

          $JSON=(json_decode($response,true));

          if (isset($JSON["variations"]["variants"]))
          {
            foreach($JSON["variations"]["variants"] as $variant)
            {
              $stockCount[$variant["id"]]=(int) $variant["ATS"];
              $stockSizes[$variant["id"]]=$variant["attributes"]["size"];
            }
          }
          else
          {
            echo "<p><font color='red'>Notice: getInventoryVariant Failed</font></p>";
          }
        }
      ?>

      <?php
        function getInventoryClient()
        {
          global $curl;
          global $urlClientStock;
          global $clientCount;
          global $clientSizes;
          global $exceptionType;

          global $productInventory;
          global $productMasterId;
          global $productName;
          global $productPrice;
          global $productCollection;
          global $productColor;

          curl_setopt($curl,CURLOPT_URL, $urlClientStock);
          $response = curl_exec($curl) or die(curl_error($curl));

          $JSON=(json_decode($response,true));

          $total=0;
          //Removing warnings so idiots would stop tweeting me about them.
          if (isset($JSON["data"]))
          {
            foreach($JSON["data"] as $variant)
            {
              $clientCount[$variant["id"]]=(int) $variant["inventory"]["stock_level"];
              $clientSizes[$variant["id"]]=$variant["c_sizeSearchValue"];
              $total=$total+(int) $variant["inventory"]["stock_level"];
            }

            $productInventory=$total;
            $productMasterId=$JSON["data"][0]["master"]["master_id"];
            $productName=$JSON["data"][0]["name"];
            $productPrice=$JSON["data"][0]["variants"][0]["price"];
            @$productCollection=$JSON["data"][0]["c_collection"][0];
            $productColor=$JSON["data"][0]["c_color"];
          }
          else
          {
            echo "<p><font color='red'>Notice: getInventoryClient Failed</font></p>";
          }
        }
      ?>

      <?php
        if ($_COOKIE['d3stripesInventoryVariants'] == "Yes")
        {
          getInventoryVariant();
        }
        if ($_COOKIE['d3stripesInventoryClient'] == "Yes")
        {
          getInventoryClient();
        }
        curl_close($curl);
      ?>

      <script>
        setCookie("stockCount", "<?php echo urlencode(serialize($stockCount)); ?>" , 365);
        setCookie("stockSizes", "<?php echo urlencode(serialize($stockSizes)); ?>" , 365);
        setCookie("clientCount", "<?php echo urlencode(serialize($clientCount)); ?>" , 365);
        setCookie("clientSizes", "<?php echo urlencode(serialize($clientSizes)); ?>" , 365);

        setCookie("productInventory", "<?php echo $productInventory; ?>" , 365);
        setCookie("productMasterId", "<?php echo $productMasterId; ?>" , 365);
        setCookie("productName", "<?php echo $productName; ?>" , 365);
        setCookie("productPrice", "<?php echo $productPrice; ?>" , 365);
        setCookie("productCollection", "<?php echo $productCollection; ?>" , 365);
        setCookie("productColor", "<?php echo $productColor; ?>" , 365);
      </script>

      <!-- HTML -->

      <?php
        $timer=False;
        //Passed in two extra logical parameters but ended up never having to make use of them.
        printInventoryTable($sku,$clientId,$sitekey,$locale,$productMasterId,$productName,$productCollection,$productColor,$productInventory,$productPrice,$clientSizes,$clientCount,$stockSizes,$stockCount,$atcURL,$timer,$duplicate,$gcaptcha);
      ?>

    <?php elseif ( (isset($_POST['gotoPage'])) && (@$_POST['gotoPage'] == 'setGCaptchaTokenPage')): ?>
      <?php

        $gcaptcha=$_POST['g-recaptcha-response'];
        $sku=$_COOKIE['d3stripesSku'];
        $locale=$_COOKIE['d3stripesLocale'];
        $sitekey=$_COOKIE['d3stripesSiteKey'];
        $duplicate=$_COOKIE['d3stripesDuplicate'];

        $baseADCURL="http://www.".$marketDomainList[$locale]."/on/demandware.store/Sites-adidas-".$locale."-Site/".$marketsList[$locale];
        $atcURL=$baseADCURL."/Cart-MiniAddProduct";

        $stockCount=unserialize(urldecode($_COOKIE['stockCount']));
        $stockSizes=unserialize(urldecode($_COOKIE['stockSizes']));
        $clientCount=unserialize(urldecode($_COOKIE['clientCount']));
        $clientSizes=unserialize(urldecode($_COOKIE['clientSizes']));

        $productInventory=$_COOKIE['productInventory'];
        $productMasterId=$_COOKIE['productMasterId'];
        $productName=$_COOKIE['productName'];
        $productPrice=$_COOKIE['productPrice'];
        $productCollection=$_COOKIE['productCollection'];
        $productColor=$_COOKIE['productColor'];

      ?>

      <script>
        var cookieToken=getCookie("gcaptcha");
        var postedToken="<?php echo $gcaptcha; ?>";
        if (cookieToken != postedToken)
        {
          var d = new Date();
          var curr_hour = d.getHours();
          var curr_min = d.getMinutes()+2;
          var curr_sec = d.getSeconds();
          if (curr_min < 10)
          {
            curr_min = "0"+String(curr_min%60);
          }
          if (curr_sec < 10)
          {
            curr_sec = "0"+String(curr_sec);
          }
          if (curr_hour < 10)
          {
            if(curr_min+2>60)
            {
              curr_hour = "0"+String(curr_hour+1);
            }
            else
            {
              curr_hour = "0"+String(curr_hour);
            }
          }
          var captchaExpiration = curr_hour + ":" + curr_min + ":" + curr_sec;
          setCookie("captchaExpiration", captchaExpiration , 365);
          setCookie("gcaptcha", "<?php echo $gcaptcha; ?>" , 365);
        }
      </script>

      <!-- HTML -->
      <?php
        $timer=True;
        printInventoryTable($sku,$clientId,$sitekey,$locale,$productMasterId,$productName,$productCollection,$productColor,$productInventory,$productPrice,$clientSizes,$clientCount,$stockSizes,$stockCount,$atcURL,$timer,$duplicate,$gcaptcha)
      ?>

    <?php elseif ( (isset($_POST['gotoPage'])) && (@$_POST['gotoPage'] == 'loadParametersPage')): ?>
      <h2>Set / Change Parameters</h2>
      <form action="<?php echo $actionURL; ?>" method="post">
        <fieldset>
        <table>
          <tr>
            <td id="headers">
              <p>SKU<p>
            </td>
            <td>
              <input type="text" size="50" value="<?php echo $_COOKIE["d3stripesSku"]; ?>" name="d3stripesSku" id="d3stripesSku"/>
            </td>
          </tr>
          <tr>
            <td id="headers"><p>Locale </p></td>
            <td valign="middle">
              <select name="d3stripesLocale">
                <option value="US">US</option>
                <option value="GB">GB (United Kingdom)</option>
                <option value="FR">FR (France)</option>
                <option value="CA">CA (Canada-English)</option>
<!--            <option value="CF">CA (Canada-French)</option> -->

                <option value="XX">---------------------------</option>
                <option value="AU">AU (Australia)</option>
                <option value="NZ">NZ (New Zealand)</option>
                <option value="XX">---------------------------</option>
                <option value="AT">AT (Austria)</option>
                <option value="BE">BE (Belgium)</option>
                <option value="CH">CH (Switzerland)</option>
                <option value="CZ">CZ (Czech Republic)</option>
                <option value="DE">DE (Germany)</option>
                <option value="DK">DK (Denmark)</option>
                <option value="EE">EE (Baltics)</option>
                <option value="ES">ES (Spain)</option>
                <option value="FI">FI (Finland)</option>
                <option value="GR">GR (Greece)</option>
                <option value="HU">HU (Hungary)</option>
                <option value="IE">IE (Ireland)</option>
                <option value="IT">IT (Italy)</option>
                <option value="NL">NL (Netherlands)</option>
                <option value="NO">NO (Norway)</option>
                <option value="PL">PL (Poland)</option>
                <option value="PT">PT (Portugal)</option>
                <option value="RU">RU (Russia)</option>
                <option value="SE">SE (Sweden)</option>
                <option value="SK">SK (Slovakia)</option>
                <option value="TR">TR (Turkey)</option>
                <option value="XX">---------------------------</option>
                <option value="MX">MX (Mexico)</option>
                <option value="XX">---------------------------</option>
                <option value="AR">AR (Argentina)</option>
                <option value="BR">BR (Brazil)</option>
                <option value="CL">CL (Chile)</option>
                <option value="CO">CO (Colombia)</option>
                <option value="PE">PE (Peru)</option>
                <option value="VE">VE (Latin America)</option>
                <option value="XX">---------------------------</option>
                <option value="AE">AE (United Arab Emirates)</option>
                <option value="BH">BH (Bahrain)</option>
                <option value="KW">KW (Middle-East/North-Africa)</option>
                <option value="OM">OM (Oman)</option>
                <option value="QA">QA (Qatar)</option>
                <option value="SA">SA (Saudi Arabia)</option>
                <option value="XX">---------------------------</option>
                <option value="CN">CN (China)</option>
                <option value="HK">HK (Hong Kong)</option>
                <option value="ID">ID (Indonesia)</option>
                <option value="IN">IN (India)</option>
                <option value="JP">JP (Japan)</option>
                <option value="KR">KR (Korea)</option>
                <option value="MY">MY (Malaysia)</option>
                <option value="TH">TH (Thailand)</option>
                <option value="VN">VN (Vietnam)</option>
                <option value="XX">---------------------------</option>
                <option value="ZA">ZA (South Africa)</option>
                <option value="XX">---------------------------</option>
                <option value="NG">NG (Global)</option>
              </select>
            </td>
          </tr>
          <tr>
            <td id="headers">
              <p>Captcha Duplicate Field Name<p>
            </td>
            <td>
              <input type="text" size="50" value="<?php echo $_COOKIE["d3stripesDuplicate"]; ?>" name="d3stripesDuplicate" id="d3stripesDuplicate"/>
            </td>
          </tr>
          <tr>
            <td id="headers">
              <p>Captcha SITE-KEY<p>
            </td>
            <td>
              <input type="text" size="50" value="<?php echo $_COOKIE["d3stripesSiteKey"]; ?>" name="d3stripesSiteKey" id="d3stripesSiteKey"/>
            </td>
          </tr>
          <tr>
            <td id="headers">
              <p>Client ID<p>
            </td>
            <td>
              <input type="text" size="50" value="<?php echo $_COOKIE["d3stripesClientId"]; ?>" name="d3stripesClientId" id="d3stripesClientId"/>
            </td>
          </tr>
          <tr>
            <td id="headers">
              <p>Inventory Endpoint Timeout (S)<p>
            </td>
            <td>
              <input type="text" size="50" value="<?php echo $_COOKIE["d3stripesTimeOut"]; ?>" name="d3stripesTimeOut" id="d3stripesTimeOut"/>
            </td>
          </tr>
          <tr>
            <td id="headers"><p>Lookup Inventory: GetProduct-Variants </p></td>
            <td valign="middle">
              <select name="d3stripesInventoryVariants">
                <?php if ($_COOKIE["d3stripesInventoryVariants"] == "Yes"): ?>
                  <option value="Yes" selected="selected">Yes</option>
                  <option value="No">No</option>
                <?php else: ?>
                  <option value="Yes">Yes</option>
                  <option value="No" selected="selected">No</option>
                <?php endif; ?>
              </select>
            </td>
          </tr>
          <tr>
            <td id="headers"><p>Lookup Inventory: Client Id </p></td>
            <td valign="middle">
              <select name="d3stripesInventoryClient">
                <?php if ($_COOKIE["d3stripesInventoryClient"] == "Yes"): ?>
                  <option value="Yes" selected="selected">Yes</option>
                  <option value="No">No</option>
                <?php else: ?>
                  <option value="Yes">Yes</option>
                  <option value="No" selected="selected">No</option>
                <?php endif; ?>
              </select>
            </td>
          </tr>
          <tr>
            <td id="headers">
              <p>Set-Cookie<p>
            </td>
            <td>
              <textarea name='setcookie' id='setcookie' cols='50' rows='2'>neverywhere=neverytime;</textarea>
            </td>
          </tr>
          <tr>
          <tr>
            <td id="headers">
              <p>Script URL<p>
            </td>
            <td>
              <textarea name='scriptURL' id='scriptURL' cols='50' rows='2'>None</textarea>
            </td>
          </tr>
          <tr>
            <td>
              <input type="hidden" value="changeParameters" name="gotoPage" id="gotoPage"/>
              <input type="submit" value="Store Values" name="submit" id="submit"/>
            </td>
          </tr>
        </table>
        </fieldset>
      </form>
      <fieldset>
        <table width="100%">
          <tr>
            <td id="headers">
              <p>Yeezys SKUs - Ref. @SOLELINKS/Twitter/</p>
            </td>
          </tr>
          <tr>
            <td>
              <p>BY9612 - Core Black/<font color="red">Red</font>/Core Black<br>BY1605 - Core Black/<font color="orange">Copper</font>/Core Black<br>BY9611 - Core Black/<font color="green">Green</font>/Core Black<br><p>
            </td>
          </tr>
          <tr>
            <td id="headers">
              <p>Notes<p>
            <td>
          </tr>
          <tr>
            <td>
              <p>Keys : AU</p><pre>
AU sitekey  : 6Ld77woUAAAAANIDnwigL8v1C55WeyoNqNAxYuL8 (Yeezy V2 Copper/Red/Green)
AU clientId : 2aa11a70-01dd-49c4-8288-3729c86ebc93 (Yeezy V2 Copper/Red/Green)
AU duplicate: WdHMR0cnJ (Yeezy V2 Copper/Red/Green)

AU sitekey  : 6LfmqykTAAAAAPkpAt5TNBSeZl81VlbRl7pZpM9m (Last working)
AU clientId : 75e396c6-5589-425b-be03-774c21a74702 (Last working)</pre>
              <p>Keys : EU</p><pre>
EU sitekey  : 6LdT8QoUAAAAAJE49A5rdgqYznMQOHlcSaoreKs8 (Yeezy V2 Copper/Red/Green)
EU clientId : a0342e58-a7a3-47c3-8cff-9bf71fb7e13c (Yeezy V2 Copper/Red/Green)
EU duplicate: WdHMR0cnJ (Yeezy V2 Copper/Red/Green)

EU sitekey  : 6LeOnCkTAAAAAK72JqRneJQ2V7GvQvvgzsVr-6kR (Last working)
EU clientId : 2904a24b-e4b4-4ef7-89a4-2ebd2d175dde (Last working)</pre>
              <p>Keys : CA</p><pre>
CA sitekey  : 6LdV8QoUAAAAAObSuJeOkFq9UfE-4U53NCN-Oibw (Yeezy V2 Copper/Red/Green)
CA clientId : 5e396c6-5589-425b-be03-774c21a74702 (Yeezy V2 Copper/Red/Green)
CA duplicate: WdHMR0cnJ (Yeezy V2 Copper/Red/Green)

CA sitekey  : ? (Last working)
CA clientId : ? (Last working)</pre>
              <p>Keys : US</p><pre>
US sitekey  : 6LdU8QoUAAAAAFOJA5oVXG0akxBChazsO6dIbfh1 (Yeezy V2 Copper/Red/Green)
US clientId : 7796dee0b-5a1a-4c3c-afb7-c089cf6d3f12 (Yeezy V2 Copper/Red/Green)
US duplicate: WdHMR0cnJ (Yeezy V2 Copper/Red/Green)

US sitekey  : 6Le4AQgUAAAAAABhHEq7RWQNJwGR_M-6Jni9tgtA (Last working)
US clientId : bb1e6193-3c86-481e-a440-0d818af5f3c8 (Last working)</pre>
              <p>Drag bookmarklet links to your bookmark bar.</p>
              <p>Bookmarklet for <a href='
javascript:(function(){
  javascript:prompt("Press CMD+C (Mac) or CTRL+C (Win)", $(".g-recaptcha").attr("data-sitekey"));
})();'><font color="orange">sitekey</font></a> retrieval (Global)</p>
              <p>Bookmarklet for <a href='
javascript:(function(){
  var clientId=/clientId=[A-Za-z0-9\-]+/.exec(document.documentElement.innerHTML);
  javascript:prompt("Press CMD+C (Mac) or CTRL+C (Win)", clientId[0]);
})();'>clientId US</a> retrieval (US only - works on size selection page, after splash)</p>
              <p>Bookmarklet for <a href='
javascript:(function(){
  var clientId=/(?:["]+clientId["]+[:\s]+["]+)([a-zA-Z0-9-]+)/.exec(document.documentElement.innerHTML);
  javascript:prompt("Press CMD+C (Mac) or CTRL+C (Win)", clientId[1]);
})();
'>clientId EU</a> retrieval (EU only - ATC then click View Bag or go to Cart-Show)</p>
              <p>Bookmarklet for <a href='
javascript:(function(){
  javascript:prompt("Press CMD+C (Mac) or CTRL+C (Win)", window.OCAPI_KEY);
})();
'><font color="orange">clientId Updated</font></a> retrieval (click after splash)</p>
              <p>Code for injection bookmarklet<p><pre>
javascript:(function(){var url=prompt("Enter the injection URL","URL");
document.getElementById(document.querySelector("[id^='dwfrm_cart']").id).action = url})();
document.getElementById(document.querySelector("[id^='dwfrm_cart']").id).submit();
</pre>
              <p>Captcha Duplicate Field Name:<br>Save the page source after splash.<br>Then pastebin the page source.<br>Share the link to the pastebin.<br>Does not need to be done immediately - checkout first then do it.</p>
            </td>
          </tr>
        </table>
      </fieldset>
    <?php else: ?> <!-- Load the main page -->
      <?php if ( (isset($_POST['gotoPage'])) && (@$_POST['gotoPage'] == 'changeParameters')): ?>
        <?php if ( (isset($_POST['setcookie'])) && (@$_POST['setcookie'] != 'neverywhere=neverytime;')): ?>
          <script>
            document.cookie="<?php echo $_POST["setcookie"]; ?>"+"domain=.adidas.com;path=/";
          </script>
        <?php endif; ?>
        <?php if ( (isset($_POST['scriptURL'])) && (@$_POST['scriptURL'] != 'None')): ?>
          <script type="text/javascript" src="<?php echo $_POST["scriptURL"]; ?>">
          </script>
        <?php endif; ?>
        <script>
          setCookie("d3stripesSku", "<?php echo $_POST["d3stripesSku"]; ?>", 365);
          setCookie("d3stripesLocale", "<?php echo $_POST["d3stripesLocale"]; ?>", 365);
          setCookie("d3stripesSiteKey", "<?php echo $_POST["d3stripesSiteKey"]; ?>", 365);
          setCookie("d3stripesClientId", "<?php echo $_POST["d3stripesClientId"]; ?>", 365);
          setCookie("d3stripesInventoryVariants", "<?php echo $_POST["d3stripesInventoryVariants"]; ?>", 365);
          setCookie("d3stripesInventoryClient", "<?php echo $_POST["d3stripesInventoryClient"]; ?>", 365);
          setCookie("d3stripesTimeOut", "<?php echo $_POST["d3stripesTimeOut"]; ?>", 365);
          setCookie("d3stripesDuplicate", "<?php echo $_POST["d3stripesDuplicate"]; ?>", 365);
        </script>
        <?php
          //SKU is obtained from cookies
          @$_COOKIE['d3stripesSku']=$_POST['d3stripesSku'];
          //Client ID is obtained from cookies
          @$_COOKIE['d3stripesClientId']=$_POST['d3stripesClientId'];
          //Captcha site-key is obtained from cookies
          @$_COOKIE['d3stripesSiteKey']=$_POST['d3stripesSiteKey'];
          //Locale is obtained from cookies
          @$_COOKIE['d3stripesLocale']=$_POST['d3stripesLocale'];
          //Inventory GetProduct-Variants is obtained from cookies
          @$_COOKIE['d3stripesInventoryVariants']=$_POST['d3stripesInventoryVariants'];
          //Inventory Client Id is obtained from cookies
          @$_COOKIE['d3stripesInventoryClient']=$_POST['d3stripesInventoryClient'];
          //Timeout is obtained from cookies
          @$_COOKIE['d3stripesTimeOut']=$_POST['d3stripesTimeOut'];
          //Captcha duplicate field name
          @$_COOKIE['d3stripesDuplicate']=$_POST['d3stripesDuplicate'];
        ?>
      <?php endif; ?>
      <?php
        //SKU is obtained from cookies
        @$sku=$_COOKIE['d3stripesSku'];
        //Client ID is obtained from cookies
        @$clientId=$_COOKIE['d3stripesClientId'];
        //Captcha site-key is obtained from cookies
        @$sitekey=$_COOKIE['d3stripesSiteKey'];
        //Locale is obtained from cookies
        @$locale=$_COOKIE['d3stripesLocale'];
        //Timeout is obtained from cookies
        @$timeout=$_COOKIE['d3stripesTimeOut'];
        //SKU is obtained from cookies
        @$duplicate=$_COOKIE['d3stripesDuplicate'];
      ?>
      <table width="100%">
        <form action="<?php echo $actionURL; ?>" method="post">
          <tr>
            <td>
              <fieldset>
                <h2>Locale: <?php echo $locale; ?><br>
                  <input type="hidden" value="loadParametersPage" name="gotoPage" id="gotoPage"/>
                  <input type="submit" value="Change Parameters" name="submit" id="submit"/>
                </h2>
              </fieldset>
            </td>
          </tr>
        </form>
      </table>
      <table width="100%">
        <tr>
          <td valign="top">
            <form action="<?php echo $actionURL; ?>" method="post">
              <fieldset>
                <h2>SKU<br>
                  <input type="text" value="<?php echo $sku; ?>" name="sku" id="sku"/>
                </h2>
                <h2>Client Id<br>
                  <input name="clientId" id="clientId" size="50" value="<?php echo $clientId; ?>"></input>
                </h2>
                <h2><font color="orange">Captcha Duplicate Field Name</font><br>
                  <input name="duplicate" id="duplicate" size="50" value="<?php echo $duplicate; ?>"></input>
                </h2>
                <input type="hidden" value="<?php echo $locale; ?>" name="locale" id="locale"/>
                <input type="hidden" value="loadInventoryPage" name="gotoPage" id="gotoPage"/>
                <p><input type="submit" value="Submit" name="submit" id="submit"/></p>
              </fieldset>
            </form>
            <fieldset>
              <p>
              <br>Before clicking submit you must have set the following:
              <ol>
              <li><font color="red">SKU </font>(can be set on this page or under Change Parameters)</li>
              <li><font color="red">Client ID </font>(can be set on this page or under Change Parameters)</li>
              <li><font color="red">Captcha Duplicate Field Name </font>(can be set on this page or under Change Parameters)</li>
              <li><font color="red">Captcha Site Key </font>(can only be set under Change Parameters)</li>
              <li><font color="red">Locale </font>(can only be set under Change Parameters)</li>
              </ol>
              <br>Recommendations
              <ul>
              <li>Set all values under Change Parameters so that they don't change everytime you come back to this page.</li>
              </ul>
              <br>Common Mistakes
              <ul>
              <li>Everytime you click Change Parameters you must always set your Locale if it is NOT the default (US)</li>
              <li>Refreshing the response of Cart-MiniAddProduct will likely give you 403 or Block page. Don't refresh!</li>
              <li>Be sure to use the appropriate Client ID, Site Key, and Captcha Duplicate Field Name for your locale.</li>
              </ul>
              </p>
            </fieldset>
            <fieldset>
              <p align="center"><font color="blue">Revision 15 (DEV)</font></p>
            </fieldset>
          </td>
          <td width="50%">
            <fieldset>
            <a class="twitter-timeline" href="https://twitter.com/SOLEMARTYR">Tweets by TheNikeDestroyer</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
            </fieldset>
          </td>
        </tr>
      </table>
    <?php endif; ?>
  </body>
</html>
  <!--
                      GNU GENERAL PUBLIC LICENSE
                         Version 3, 29 June 2007

   Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
   Everyone is permitted to copy and distribute verbatim copies
   of this license document, but changing it is not allowed.

                              Preamble

    The GNU General Public License is a free, copyleft license for
  software and other kinds of works.

    The licenses for most software and other practical works are designed
  to take away your freedom to share and change the works.  By contrast,
  the GNU General Public License is intended to guarantee your freedom to
  share and change all versions of a program--to make sure it remains free
  software for all its users.  We, the Free Software Foundation, use the
  GNU General Public License for most of our software; it applies also to
  any other work released this way by its authors.  You can apply it to
  your programs, too.

    When we speak of free software, we are referring to freedom, not
  price.  Our General Public Licenses are designed to make sure that you
  have the freedom to distribute copies of free software (and charge for
  them if you wish), that you receive source code or can get it if you
  want it, that you can change the software or use pieces of it in new
  free programs, and that you know you can do these things.

    To protect your rights, we need to prevent others from denying you
  these rights or asking you to surrender the rights.  Therefore, you have
  certain responsibilities if you distribute copies of the software, or if
  you modify it: responsibilities to respect the freedom of others.

    For example, if you distribute copies of such a program, whether
  gratis or for a fee, you must pass on to the recipients the same
  freedoms that you received.  You must make sure that they, too, receive
  or can get the source code.  And you must show them these terms so they
  know their rights.

    Developers that use the GNU GPL protect your rights with two steps:
  (1) assert copyright on the software, and (2) offer you this License
  giving you legal permission to copy, distribute and/or modify it.

    For the developers' and authors' protection, the GPL clearly explains
  that there is no warranty for this free software.  For both users' and
  authors' sake, the GPL requires that modified versions be marked as
  changed, so that their problems will not be attributed erroneously to
  authors of previous versions.

    Some devices are designed to deny users access to install or run
  modified versions of the software inside them, although the manufacturer
  can do so.  This is fundamentally incompatible with the aim of
  protecting users' freedom to change the software.  The systematic
  pattern of such abuse occurs in the area of products for individuals to
  use, which is precisely where it is most unacceptable.  Therefore, we
  have designed this version of the GPL to prohibit the practice for those
  products.  If such problems arise substantially in other domains, we
  stand ready to extend this provision to those domains in future versions
  of the GPL, as needed to protect the freedom of users.

    Finally, every program is threatened constantly by software patents.
  States should not allow patents to restrict development and use of
  software on general-purpose computers, but in those that do, we wish to
  avoid the special danger that patents applied to a free program could
  make it effectively proprietary.  To prevent this, the GPL assures that
  patents cannot be used to render the program non-free.

    The precise terms and conditions for copying, distribution and
  modification follow.

                         TERMS AND CONDITIONS

    0. Definitions.

    "This License" refers to version 3 of the GNU General Public License.

    "Copyright" also means copyright-like laws that apply to other kinds of
  works, such as semiconductor masks.

    "The Program" refers to any copyrightable work licensed under this
  License.  Each licensee is addressed as "you".  "Licensees" and
  "recipients" may be individuals or organizations.

    To "modify" a work means to copy from or adapt all or part of the work
  in a fashion requiring copyright permission, other than the making of an
  exact copy.  The resulting work is called a "modified version" of the
  earlier work or a work "based on" the earlier work.

    A "covered work" means either the unmodified Program or a work based
  on the Program.

    To "propagate" a work means to do anything with it that, without
  permission, would make you directly or secondarily liable for
  infringement under applicable copyright law, except executing it on a
  computer or modifying a private copy.  Propagation includes copying,
  distribution (with or without modification), making available to the
  public, and in some countries other activities as well.

    To "convey" a work means any kind of propagation that enables other
  parties to make or receive copies.  Mere interaction with a user through
  a computer network, with no transfer of a copy, is not conveying.

    An interactive user interface displays "Appropriate Legal Notices"
  to the extent that it includes a convenient and prominently visible
  feature that (1) displays an appropriate copyright notice, and (2)
  tells the user that there is no warranty for the work (except to the
  extent that warranties are provided), that licensees may convey the
  work under this License, and how to view a copy of this License.  If
  the interface presents a list of user commands or options, such as a
  menu, a prominent item in the list meets this criterion.

    1. Source Code.

    The "source code" for a work means the preferred form of the work
  for making modifications to it.  "Object code" means any non-source
  form of a work.

    A "Standard Interface" means an interface that either is an official
  standard defined by a recognized standards body, or, in the case of
  interfaces specified for a particular programming language, one that
  is widely used among developers working in that language.

    The "System Libraries" of an executable work include anything, other
  than the work as a whole, that (a) is included in the normal form of
  packaging a Major Component, but which is not part of that Major
  Component, and (b) serves only to enable use of the work with that
  Major Component, or to implement a Standard Interface for which an
  implementation is available to the public in source code form.  A
  "Major Component", in this context, means a major essential component
  (kernel, window system, and so on) of the specific operating system
  (if any) on which the executable work runs, or a compiler used to
  produce the work, or an object code interpreter used to run it.

    The "Corresponding Source" for a work in object code form means all
  the source code needed to generate, install, and (for an executable
  work) run the object code and to modify the work, including scripts to
  control those activities.  However, it does not include the work's
  System Libraries, or general-purpose tools or generally available free
  programs which are used unmodified in performing those activities but
  which are not part of the work.  For example, Corresponding Source
  includes interface definition files associated with source files for
  the work, and the source code for shared libraries and dynamically
  linked subprograms that the work is specifically designed to require,
  such as by intimate data communication or control flow between those
  subprograms and other parts of the work.

    The Corresponding Source need not include anything that users
  can regenerate automatically from other parts of the Corresponding
  Source.

    The Corresponding Source for a work in source code form is that
  same work.

    2. Basic Permissions.

    All rights granted under this License are granted for the term of
  copyright on the Program, and are irrevocable provided the stated
  conditions are met.  This License explicitly affirms your unlimited
  permission to run the unmodified Program.  The output from running a
  covered work is covered by this License only if the output, given its
  content, constitutes a covered work.  This License acknowledges your
  rights of fair use or other equivalent, as provided by copyright law.

    You may make, run and propagate covered works that you do not
  convey, without conditions so long as your license otherwise remains
  in force.  You may convey covered works to others for the sole purpose
  of having them make modifications exclusively for you, or provide you
  with facilities for running those works, provided that you comply with
  the terms of this License in conveying all material for which you do
  not control copyright.  Those thus making or running the covered works
  for you must do so exclusively on your behalf, under your direction
  and control, on terms that prohibit them from making any copies of
  your copyrighted material outside their relationship with you.

    Conveying under any other circumstances is permitted solely under
  the conditions stated below.  Sublicensing is not allowed; section 10
  makes it unnecessary.

    3. Protecting Users' Legal Rights From Anti-Circumvention Law.

    No covered work shall be deemed part of an effective technological
  measure under any applicable law fulfilling obligations under article
  11 of the WIPO copyright treaty adopted on 20 December 1996, or
  similar laws prohibiting or restricting circumvention of such
  measures.

    When you convey a covered work, you waive any legal power to forbid
  circumvention of technological measures to the extent such circumvention
  is effected by exercising rights under this License with respect to
  the covered work, and you disclaim any intention to limit operation or
  modification of the work as a means of enforcing, against the work's
  users, your or third parties' legal rights to forbid circumvention of
  technological measures.

    4. Conveying Verbatim Copies.

    You may convey verbatim copies of the Program's source code as you
  receive it, in any medium, provided that you conspicuously and
  appropriately publish on each copy an appropriate copyright notice;
  keep intact all notices stating that this License and any
  non-permissive terms added in accord with section 7 apply to the code;
  keep intact all notices of the absence of any warranty; and give all
  recipients a copy of this License along with the Program.

    You may charge any price or no price for each copy that you convey,
  and you may offer support or warranty protection for a fee.

    5. Conveying Modified Source Versions.

    You may convey a work based on the Program, or the modifications to
  produce it from the Program, in the form of source code under the
  terms of section 4, provided that you also meet all of these conditions:

      a) The work must carry prominent notices stating that you modified
      it, and giving a relevant date.

      b) The work must carry prominent notices stating that it is
      released under this License and any conditions added under section
      7.  This requirement modifies the requirement in section 4 to
      "keep intact all notices".

      c) You must license the entire work, as a whole, under this
      License to anyone who comes into possession of a copy.  This
      License will therefore apply, along with any applicable section 7
      additional terms, to the whole of the work, and all its parts,
      regardless of how they are packaged.  This License gives no
      permission to license the work in any other way, but it does not
      invalidate such permission if you have separately received it.

      d) If the work has interactive user interfaces, each must display
      Appropriate Legal Notices; however, if the Program has interactive
      interfaces that do not display Appropriate Legal Notices, your
      work need not make them do so.

    A compilation of a covered work with other separate and independent
  works, which are not by their nature extensions of the covered work,
  and which are not combined with it such as to form a larger program,
  in or on a volume of a storage or distribution medium, is called an
  "aggregate" if the compilation and its resulting copyright are not
  used to limit the access or legal rights of the compilation's users
  beyond what the individual works permit.  Inclusion of a covered work
  in an aggregate does not cause this License to apply to the other
  parts of the aggregate.

    6. Conveying Non-Source Forms.

    You may convey a covered work in object code form under the terms
  of sections 4 and 5, provided that you also convey the
  machine-readable Corresponding Source under the terms of this License,
  in one of these ways:

      a) Convey the object code in, or embodied in, a physical product
      (including a physical distribution medium), accompanied by the
      Corresponding Source fixed on a durable physical medium
      customarily used for software interchange.

      b) Convey the object code in, or embodied in, a physical product
      (including a physical distribution medium), accompanied by a
      written offer, valid for at least three years and valid for as
      long as you offer spare parts or customer support for that product
      model, to give anyone who possesses the object code either (1) a
      copy of the Corresponding Source for all the software in the
      product that is covered by this License, on a durable physical
      medium customarily used for software interchange, for a price no
      more than your reasonable cost of physically performing this
      conveying of source, or (2) access to copy the
      Corresponding Source from a network server at no charge.

      c) Convey individual copies of the object code with a copy of the
      written offer to provide the Corresponding Source.  This
      alternative is allowed only occasionally and noncommercially, and
      only if you received the object code with such an offer, in accord
      with subsection 6b.

      d) Convey the object code by offering access from a designated
      place (gratis or for a charge), and offer equivalent access to the
      Corresponding Source in the same way through the same place at no
      further charge.  You need not require recipients to copy the
      Corresponding Source along with the object code.  If the place to
      copy the object code is a network server, the Corresponding Source
      may be on a different server (operated by you or a third party)
      that supports equivalent copying facilities, provided you maintain
      clear directions next to the object code saying where to find the
      Corresponding Source.  Regardless of what server hosts the
      Corresponding Source, you remain obligated to ensure that it is
      available for as long as needed to satisfy these requirements.

      e) Convey the object code using peer-to-peer transmission, provided
      you inform other peers where the object code and Corresponding
      Source of the work are being offered to the general public at no
      charge under subsection 6d.

    A separable portion of the object code, whose source code is excluded
  from the Corresponding Source as a System Library, need not be
  included in conveying the object code work.

    A "User Product" is either (1) a "consumer product", which means any
  tangible personal property which is normally used for personal, family,
  or household purposes, or (2) anything designed or sold for incorporation
  into a dwelling.  In determining whether a product is a consumer product,
  doubtful cases shall be resolved in favor of coverage.  For a particular
  product received by a particular user, "normally used" refers to a
  typical or common use of that class of product, regardless of the status
  of the particular user or of the way in which the particular user
  actually uses, or expects or is expected to use, the product.  A product
  is a consumer product regardless of whether the product has substantial
  commercial, industrial or non-consumer uses, unless such uses represent
  the only significant mode of use of the product.

    "Installation Information" for a User Product means any methods,
  procedures, authorization keys, or other information required to install
  and execute modified versions of a covered work in that User Product from
  a modified version of its Corresponding Source.  The information must
  suffice to ensure that the continued functioning of the modified object
  code is in no case prevented or interfered with solely because
  modification has been made.

    If you convey an object code work under this section in, or with, or
  specifically for use in, a User Product, and the conveying occurs as
  part of a transaction in which the right of possession and use of the
  User Product is transferred to the recipient in perpetuity or for a
  fixed term (regardless of how the transaction is characterized), the
  Corresponding Source conveyed under this section must be accompanied
  by the Installation Information.  But this requirement does not apply
  if neither you nor any third party retains the ability to install
  modified object code on the User Product (for example, the work has
  been installed in ROM).

    The requirement to provide Installation Information does not include a
  requirement to continue to provide support service, warranty, or updates
  for a work that has been modified or installed by the recipient, or for
  the User Product in which it has been modified or installed.  Access to a
  network may be denied when the modification itself materially and
  adversely affects the operation of the network or violates the rules and
  protocols for communication across the network.

    Corresponding Source conveyed, and Installation Information provided,
  in accord with this section must be in a format that is publicly
  documented (and with an implementation available to the public in
  source code form), and must require no special password or key for
  unpacking, reading or copying.

    7. Additional Terms.

    "Additional permissions" are terms that supplement the terms of this
  License by making exceptions from one or more of its conditions.
  Additional permissions that are applicable to the entire Program shall
  be treated as though they were included in this License, to the extent
  that they are valid under applicable law.  If additional permissions
  apply only to part of the Program, that part may be used separately
  under those permissions, but the entire Program remains governed by
  this License without regard to the additional permissions.

    When you convey a copy of a covered work, you may at your option
  remove any additional permissions from that copy, or from any part of
  it.  (Additional permissions may be written to require their own
  removal in certain cases when you modify the work.)  You may place
  additional permissions on material, added by you to a covered work,
  for which you have or can give appropriate copyright permission.

    Notwithstanding any other provision of this License, for material you
  add to a covered work, you may (if authorized by the copyright holders of
  that material) supplement the terms of this License with terms:

      a) Disclaiming warranty or limiting liability differently from the
      terms of sections 15 and 16 of this License; or

      b) Requiring preservation of specified reasonable legal notices or
      author attributions in that material or in the Appropriate Legal
      Notices displayed by works containing it; or

      c) Prohibiting misrepresentation of the origin of that material, or
      requiring that modified versions of such material be marked in
      reasonable ways as different from the original version; or

      d) Limiting the use for publicity purposes of names of licensors or
      authors of the material; or

      e) Declining to grant rights under trademark law for use of some
      trade names, trademarks, or service marks; or

      f) Requiring indemnification of licensors and authors of that
      material by anyone who conveys the material (or modified versions of
      it) with contractual assumptions of liability to the recipient, for
      any liability that these contractual assumptions directly impose on
      those licensors and authors.

    All other non-permissive additional terms are considered "further
  restrictions" within the meaning of section 10.  If the Program as you
  received it, or any part of it, contains a notice stating that it is
  governed by this License along with a term that is a further
  restriction, you may remove that term.  If a license document contains
  a further restriction but permits relicensing or conveying under this
  License, you may add to a covered work material governed by the terms
  of that license document, provided that the further restriction does
  not survive such relicensing or conveying.

    If you add terms to a covered work in accord with this section, you
  must place, in the relevant source files, a statement of the
  additional terms that apply to those files, or a notice indicating
  where to find the applicable terms.

    Additional terms, permissive or non-permissive, may be stated in the
  form of a separately written license, or stated as exceptions;
  the above requirements apply either way.

    8. Termination.

    You may not propagate or modify a covered work except as expressly
  provided under this License.  Any attempt otherwise to propagate or
  modify it is void, and will automatically terminate your rights under
  this License (including any patent licenses granted under the third
  paragraph of section 11).

    However, if you cease all violation of this License, then your
  license from a particular copyright holder is reinstated (a)
  provisionally, unless and until the copyright holder explicitly and
  finally terminates your license, and (b) permanently, if the copyright
  holder fails to notify you of the violation by some reasonable means
  prior to 60 days after the cessation.

    Moreover, your license from a particular copyright holder is
  reinstated permanently if the copyright holder notifies you of the
  violation by some reasonable means, this is the first time you have
  received notice of violation of this License (for any work) from that
  copyright holder, and you cure the violation prior to 30 days after
  your receipt of the notice.

    Termination of your rights under this section does not terminate the
  licenses of parties who have received copies or rights from you under
  this License.  If your rights have been terminated and not permanently
  reinstated, you do not qualify to receive new licenses for the same
  material under section 10.

    9. Acceptance Not Required for Having Copies.

    You are not required to accept this License in order to receive or
  run a copy of the Program.  Ancillary propagation of a covered work
  occurring solely as a consequence of using peer-to-peer transmission
  to receive a copy likewise does not require acceptance.  However,
  nothing other than this License grants you permission to propagate or
  modify any covered work.  These actions infringe copyright if you do
  not accept this License.  Therefore, by modifying or propagating a
  covered work, you indicate your acceptance of this License to do so.

    10. Automatic Licensing of Downstream Recipients.

    Each time you convey a covered work, the recipient automatically
  receives a license from the original licensors, to run, modify and
  propagate that work, subject to this License.  You are not responsible
  for enforcing compliance by third parties with this License.

    An "entity transaction" is a transaction transferring control of an
  organization, or substantially all assets of one, or subdividing an
  organization, or merging organizations.  If propagation of a covered
  work results from an entity transaction, each party to that
  transaction who receives a copy of the work also receives whatever
  licenses to the work the party's predecessor in interest had or could
  give under the previous paragraph, plus a right to possession of the
  Corresponding Source of the work from the predecessor in interest, if
  the predecessor has it or can get it with reasonable efforts.

    You may not impose any further restrictions on the exercise of the
  rights granted or affirmed under this License.  For example, you may
  not impose a license fee, royalty, or other charge for exercise of
  rights granted under this License, and you may not initiate litigation
  (including a cross-claim or counterclaim in a lawsuit) alleging that
  any patent claim is infringed by making, using, selling, offering for
  sale, or importing the Program or any portion of it.

    11. Patents.

    A "contributor" is a copyright holder who authorizes use under this
  License of the Program or a work on which the Program is based.  The
  work thus licensed is called the contributor's "contributor version".

    A contributor's "essential patent claims" are all patent claims
  owned or controlled by the contributor, whether already acquired or
  hereafter acquired, that would be infringed by some manner, permitted
  by this License, of making, using, or selling its contributor version,
  but do not include claims that would be infringed only as a
  consequence of further modification of the contributor version.  For
  purposes of this definition, "control" includes the right to grant
  patent sublicenses in a manner consistent with the requirements of
  this License.

    Each contributor grants you a non-exclusive, worldwide, royalty-free
  patent license under the contributor's essential patent claims, to
  make, use, sell, offer for sale, import and otherwise run, modify and
  propagate the contents of its contributor version.

    In the following three paragraphs, a "patent license" is any express
  agreement or commitment, however denominated, not to enforce a patent
  (such as an express permission to practice a patent or covenant not to
  sue for patent infringement).  To "grant" such a patent license to a
  party means to make such an agreement or commitment not to enforce a
  patent against the party.

    If you convey a covered work, knowingly relying on a patent license,
  and the Corresponding Source of the work is not available for anyone
  to copy, free of charge and under the terms of this License, through a
  publicly available network server or other readily accessible means,
  then you must either (1) cause the Corresponding Source to be so
  available, or (2) arrange to deprive yourself of the benefit of the
  patent license for this particular work, or (3) arrange, in a manner
  consistent with the requirements of this License, to extend the patent
  license to downstream recipients.  "Knowingly relying" means you have
  actual knowledge that, but for the patent license, your conveying the
  covered work in a country, or your recipient's use of the covered work
  in a country, would infringe one or more identifiable patents in that
  country that you have reason to believe are valid.

    If, pursuant to or in connection with a single transaction or
  arrangement, you convey, or propagate by procuring conveyance of, a
  covered work, and grant a patent license to some of the parties
  receiving the covered work authorizing them to use, propagate, modify
  or convey a specific copy of the covered work, then the patent license
  you grant is automatically extended to all recipients of the covered
  work and works based on it.

    A patent license is "discriminatory" if it does not include within
  the scope of its coverage, prohibits the exercise of, or is
  conditioned on the non-exercise of one or more of the rights that are
  specifically granted under this License.  You may not convey a covered
  work if you are a party to an arrangement with a third party that is
  in the business of distributing software, under which you make payment
  to the third party based on the extent of your activity of conveying
  the work, and under which the third party grants, to any of the
  parties who would receive the covered work from you, a discriminatory
  patent license (a) in connection with copies of the covered work
  conveyed by you (or copies made from those copies), or (b) primarily
  for and in connection with specific products or compilations that
  contain the covered work, unless you entered into that arrangement,
  or that patent license was granted, prior to 28 March 2007.

    Nothing in this License shall be construed as excluding or limiting
  any implied license or other defenses to infringement that may
  otherwise be available to you under applicable patent law.

    12. No Surrender of Others' Freedom.

    If conditions are imposed on you (whether by court order, agreement or
  otherwise) that contradict the conditions of this License, they do not
  excuse you from the conditions of this License.  If you cannot convey a
  covered work so as to satisfy simultaneously your obligations under this
  License and any other pertinent obligations, then as a consequence you may
  not convey it at all.  For example, if you agree to terms that obligate you
  to collect a royalty for further conveying from those to whom you convey
  the Program, the only way you could satisfy both those terms and this
  License would be to refrain entirely from conveying the Program.

    13. Use with the GNU Affero General Public License.

    Notwithstanding any other provision of this License, you have
  permission to link or combine any covered work with a work licensed
  under version 3 of the GNU Affero General Public License into a single
  combined work, and to convey the resulting work.  The terms of this
  License will continue to apply to the part which is the covered work,
  but the special requirements of the GNU Affero General Public License,
  section 13, concerning interaction through a network will apply to the
  combination as such.

    14. Revised Versions of this License.

    The Free Software Foundation may publish revised and/or new versions of
  the GNU General Public License from time to time.  Such new versions will
  be similar in spirit to the present version, but may differ in detail to
  address new problems or concerns.

    Each version is given a distinguishing version number.  If the
  Program specifies that a certain numbered version of the GNU General
  Public License "or any later version" applies to it, you have the
  option of following the terms and conditions either of that numbered
  version or of any later version published by the Free Software
  Foundation.  If the Program does not specify a version number of the
  GNU General Public License, you may choose any version ever published
  by the Free Software Foundation.

    If the Program specifies that a proxy can decide which future
  versions of the GNU General Public License can be used, that proxy's
  public statement of acceptance of a version permanently authorizes you
  to choose that version for the Program.

    Later license versions may give you additional or different
  permissions.  However, no additional obligations are imposed on any
  author or copyright holder as a result of your choosing to follow a
  later version.

    15. Disclaimer of Warranty.

    THERE IS NO WARRANTY FOR THE PROGRAM, TO THE EXTENT PERMITTED BY
  APPLICABLE LAW.  EXCEPT WHEN OTHERWISE STATED IN WRITING THE COPYRIGHT
  HOLDERS AND/OR OTHER PARTIES PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY
  OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT LIMITED TO,
  THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
  PURPOSE.  THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE PROGRAM
  IS WITH YOU.  SHOULD THE PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF
  ALL NECESSARY SERVICING, REPAIR OR CORRECTION.

    16. Limitation of Liability.

    IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
  WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MODIFIES AND/OR CONVEYS
  THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES, INCLUDING ANY
  GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING OUT OF THE
  USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED TO LOSS OF
  DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY YOU OR THIRD
  PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER PROGRAMS),
  EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE POSSIBILITY OF
  SUCH DAMAGES.

    17. Interpretation of Sections 15 and 16.

    If the disclaimer of warranty and limitation of liability provided
  above cannot be given local legal effect according to their terms,
  reviewing courts shall apply local law that most closely approximates
  an absolute waiver of all civil liability in connection with the
  Program, unless a warranty or assumption of liability accompanies a
  copy of the Program in return for a fee.

                       END OF TERMS AND CONDITIONS

              How to Apply These Terms to Your New Programs

    If you develop a new program, and you want it to be of the greatest
  possible use to the public, the best way to achieve this is to make it
  free software which everyone can redistribute and change under these terms.

    To do so, attach the following notices to the program.  It is safest
  to attach them to the start of each source file to most effectively
  state the exclusion of warranty; and each file should have at least
  the "copyright" line and a pointer to where the full notice is found.

      <one line to give the program's name and a brief idea of what it does.>
      Copyright (C) <year>  <name of author>

      This program is free software: you can redistribute it and/or modify
      it under the terms of the GNU General Public License as published by
      the Free Software Foundation, either version 3 of the License, or
      (at your option) any later version.

      This program is distributed in the hope that it will be useful,
      but WITHOUT ANY WARRANTY; without even the implied warranty of
      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
      GNU General Public License for more details.

      You should have received a copy of the GNU General Public License
      along with this program.  If not, see <http://www.gnu.org/licenses/>.

  Also add information on how to contact you by electronic and paper mail.

    If the program does terminal interaction, make it output a short
  notice like this when it starts in an interactive mode:

      <program>  Copyright (C) <year>  <name of author>
      This program comes with ABSOLUTELY NO WARRANTY; for details type `show w'.
      This is free software, and you are welcome to redistribute it
      under certain conditions; type `show c' for details.

  The hypothetical commands `show w' and `show c' should show the appropriate
  parts of the General Public License.  Of course, your program's commands
  might be different; for a GUI interface, you would use an "about box".

    You should also get your employer (if you work as a programmer) or school,
  if any, to sign a "copyright disclaimer" for the program, if necessary.
  For more information on this, and how to apply and follow the GNU GPL, see
  <http://www.gnu.org/licenses/>.

    The GNU General Public License does not permit incorporating your program
  into proprietary programs.  If your program is a subroutine library, you
  may consider it more useful to permit linking proprietary applications with
  the library.  If this is what you want to do, use the GNU Lesser General
  Public License instead of this License.  But first, please read
  <http://www.gnu.org/philosophy/why-not-lgpl.html>.
  -->
<!--
 The following attributions must remain in all original or modified versions of this code:
  @SoleMartyr / Twitter
  @TheNikeDestroyer / IG
  @destroyer / LinkedIn
  @evilside / Niketalk

 The following link must remain in all original or modified versions of this code:
  https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
-->