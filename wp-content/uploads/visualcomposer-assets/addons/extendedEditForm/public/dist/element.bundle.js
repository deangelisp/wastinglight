(window.vcvWebpackJsonp4x=window.vcvWebpackJsonp4x||[]).push([[0],{"./extendedEditForm/index.js":function(e,t,a){"use strict";a.r(t);var n=a("./node_modules/@babel/runtime/helpers/toConsumableArray.js"),r=a.n(n),l=a("./node_modules/vc-cake/index.js"),i=a("./extendedEditForm/public/src/premiumLibs.json"),s=a("./node_modules/@babel/runtime/helpers/classCallCheck.js"),o=a.n(s),d=a("./node_modules/@babel/runtime/helpers/createClass.js"),c=a.n(d),u=Object(l.getService)("document"),b=Object(l.getService)("cook"),p=Object(l.getStorage)("assets"),m=function(){function e(){o()(this,e)}return c()(e,[{key:"removeAttrs",value:function(e,t){e.forEach((function(e){var a=e.split(/(?=[A-Z])/).join("-").toLowerCase();t.removeAttribute("data-".concat(a))})),t.style="",t.classList.remove("vce-tilt")}},{key:"handleParallaxOptions",value:function(e){var t=e.id,a=b.getById(t).getAll();if(!a.parallax||(!Array.isArray(a.parallax)||a.parallax.length)&&a.parallax.device){var n=e.ref,r=Object.keys(n.dataset).filter((function(e){return e.toLocaleLowerCase().indexOf("tilt")>-1})),l=a.parallax.device,s=Object.keys(l);r&&this.removeAttrs(r,n);var o=!1;s.forEach((function(e){var a=l[e].parallax,r=i.find((function(e){return e.value===a}));if(!o&&r){o=r;var s=u.get(t);p.trigger("editSharedLibrary",s)}if(r&&r.value.indexOf("tilt")>-1){var d=l[e].parallaxEnable?"".concat(l[e].parallaxEnable,":").concat(a):l[e].parallaxEnable;n.setAttribute("data-vce-tilt-".concat(e),d),n.classList.add("vce-tilt")}}))}}}]),e}(),v=a("./node_modules/@babel/runtime/helpers/extends.js"),f=a.n(v),y=a("./node_modules/react/index.js"),g=a.n(y),x=a("./node_modules/classnames/index.js"),h=a.n(x),j=a("./node_modules/react-dom/server.browser.js");function A(e){var t=e.deviceKey,a=e.content,n={"data-vce-asset-background-animation":!0,"data-vce-asset-background-animation-element":e.atts.id},r=["vce-asset-background-animation-container","vce-visible-".concat(t,"-only")],l=["vce-asset-background-animation"];l.push("vcvhelper");var i=Object(j.renderToString)(g.a.createElement("div",{className:"vce-asset-background-animation"},a));return g.a.createElement("div",f()({className:h()(r)},n),g.a.createElement("div",{className:h()(l),"data-vcvs-html":i}))}var O,k=Object(l.getService)("cook"),T=Object(l.getStorage)("fieldOptions"),w=Object(l.getStorage)("elementsSettings"),S=Object(l.getStorage)("assets"),_=["parallax"],E=new m;function C(e){_.includes(e.fieldType)&&"parallax"===e.fieldType&&E.handleParallaxOptions(e)}function K(e){var t=w.state("extendedOptions").get(),a=t&&t.elements?t.elements:[],n=a.findIndex((function(t){return t.id===e.id}));n<0?a.push(e):(a[n].id=e.id,a[n].fieldKey=e.fieldKey,a[n].fieldType=e.fieldType),w.state("extendedOptions").set({elements:a,backgroundAnimationComponent:A})}O=(O=S.state("attributeLibs").get())?[O].concat(r()(i)):i,S.state("attributeLibs").set(O),T.on("fieldOptions",(function(e,t){var a,n=i.filter((function(t){return e===t.fieldKey}));(a=t.values).push.apply(a,r()(n)),T.state("currentAttribute:settings").set(t)})),T.on("fieldOptionsChange",(function(e){_.includes(e.fieldType)?K(e):function(e){var t=k.getById(e.id).getAll(),a=e.id;_.forEach((function(e){"parallax"===e&&t[e]&&K({fieldKey:e,fieldType:e,id:a})}))}(e)})),w.state("elementOptions").onChange(C)},"./extendedEditForm/public/src/premiumLibs.json":function(e){e.exports=JSON.parse('[{"fieldKey":"parallax","value":"tilt","label":"Tilt","library":"vanillaTilt","dependencies":[]},{"fieldKey":"parallax","value":"tilt-glare","label":"Tilt glare","library":"vanillaTilt","dependencies":[]},{"fieldKey":"parallax","value":"tilt-reverse","label":"Tilt reverse","library":"vanillaTilt","dependencies":[]},{"fieldKey":"parallax","value":"tilt-reset","label":"Tilt reset","library":"vanillaTilt","dependencies":[]},{"fieldKey":"parallax","value":"backgroundAnimation","label":"Mouse follow animation","description":"Animation will work with multiple images selected as a background.","library":"backgroundAnimation","dependencies":["anime"]}]')},"./node_modules/@babel/runtime/helpers/arrayWithoutHoles.js":function(e,t){e.exports=function(e){if(Array.isArray(e)){for(var t=0,a=new Array(e.length);t<e.length;t++)a[t]=e[t];return a}}},"./node_modules/@babel/runtime/helpers/iterableToArray.js":function(e,t){e.exports=function(e){if(Symbol.iterator in Object(e)||"[object Arguments]"===Object.prototype.toString.call(e))return Array.from(e)}},"./node_modules/@babel/runtime/helpers/nonIterableSpread.js":function(e,t){e.exports=function(){throw new TypeError("Invalid attempt to spread non-iterable instance")}},"./node_modules/@babel/runtime/helpers/toConsumableArray.js":function(e,t,a){var n=a("./node_modules/@babel/runtime/helpers/arrayWithoutHoles.js"),r=a("./node_modules/@babel/runtime/helpers/iterableToArray.js"),l=a("./node_modules/@babel/runtime/helpers/nonIterableSpread.js");e.exports=function(e){return n(e)||r(e)||l()}}},[["./extendedEditForm/index.js"]]]);