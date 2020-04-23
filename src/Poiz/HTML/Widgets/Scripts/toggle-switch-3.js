(this["webpackJsonptoggle-switch"]=this["webpackJsonptoggle-switch"]||[]).push([[0],{0:function(t){t.exports=toggleSwitchConfig},12:function(t,e,s){t.exports=s(18)},17:function(t,e,s){},18:function(t,e,s){"use strict";s.r(e);var a=s(1),i=s.n(a),n=s(10),o=s.n(n),c=s(3),r=s(4),l=s(8),h=s(2),u=s(6),p=s(5),f=s.n(p),d=s(0),m=s(11),_=function(){function t(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"session",s=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"default";Object(c.a)(this,t),this._adapter=e,this._namespace=s,this._instance=this,this._store={},this._data={},this.init()}return Object(r.a)(t,[{key:"init",value:function(){return this.bake(),this}},{key:"bake",value:function(){"undefined"!==typeof Storage&&(this.syncStore(),this._store[this._namespace]=void 0===this._store[this._namespace]?{}:this._store[this._namespace],"session"===this._adapter?sessionStorage.setItem(this._namespace,JSON.stringify(this._store)):"local"===this._adapter&&localStorage.setItem(this._namespace,JSON.stringify(this._store)))}},{key:"getProp",value:function(t,e,s){return this.syncStore(),s=void 0===s?null:s,void 0!==this._store[this._namespace][t]&&void 0!==this._store[this._namespace][t][e]?this._store[this._namespace][t][e]:s}},{key:"getAll",value:function(t,e){return this.syncStore(),e=void 0===e?{}:e,void 0===this._store[this._namespace][t]?e:this._store[this._namespace][t]}},{key:"setProp",value:function(t,e,s){this.syncStore(),void 0===this._store[this._namespace][t]&&(this._store[this._namespace][t]=this._data),this._store[this._namespace][t][e]=s,this.save()}},{key:"add",value:function(t,e,s){this.setProp(t,e,s)}},{key:"setAdapter",value:function(t){this._adapter=t}},{key:"has",value:function(t,e){return this.syncStore(),void 0!==this._store[this._namespace][t]&&void 0!==this._store[this._namespace][t][e]}},{key:"hasKey",value:function(t){return void 0!==this._store[this._namespace][t]}},{key:"storeHasKey",value:function(t){if("undefined"!==typeof Storage){var e=null;return"session"===this._adapter?e=sessionStorage.getItem(this._namespace):"local"===this._adapter&&(e=localStorage.getItem(this._namespace)),void 0!==e&&e?toggleSwitchConfig[t]:!1}return alert("This App will not run very well without Web Storage Support on your Browsers.\nPlease, install a Modern Browser with Web-Storage Support..."),!1}},{key:"syncStore",value:function(){var e=null,s={};"session"===this._adapter?e=sessionStorage.getItem(this._namespace):"local"===this._adapter&&(e=localStorage.getItem(this._namespace)),void 0!==e&&e&&(s=toggleSwitchConfig),this._store=t.extend({},this._store,s)}},{key:"save",value:function(){"undefined"!==typeof Storage&&("session"===this._adapter?sessionStorage.setItem(this._namespace,JSON.stringify(this._store)):"local"===this._adapter&&localStorage.setItem(this._namespace,JSON.stringify(this._store)))}},{key:"store",get:function(){return this._store},set:function(t){this._store=t}},{key:"data",get:function(){return this._data},set:function(t){this._data=t}},{key:"adapter",get:function(){return this._adapter},set:function(t){this._adapter=t}},{key:"namespace",get:function(){return this._namespace},set:function(t){this._namespace=t}},{key:"instance",get:function(){return this._instance},set:function(t){this._instance=t}}],[{key:"extend",value:function(){for(var t=arguments.length,e=new Array(t),s=0;s<t;s++)e[s]=arguments[s];if(e.length<1)return null;for(var a=1;a<arguments.length;a++)for(var i in arguments[a])arguments[a].hasOwnProperty(i)&&(arguments[0][i]=arguments[a][i]);return arguments[0]}}]),t}(),g=(Object(m.a)(Object),_),v=(s(17),function(t){function e(t){var s;return Object(c.a)(this,e),(s=Object(l.a)(this,Object(h.a)(e).call(this,t))).widgetDataKey=d.widgetDataKey,s.StoreKey="widgets",s.onOffColors={onColor:"#11ff00",offColor:"#ff1100"},s.inputRefs={searchFilter:i.a.createRef(),multiOptions:i.a.createRef()},s.runClickAction=function(t){var e={switchOffOnClass:"pz-col-on"===s.state.switchOffOnClass?"pz-col-off":"pz-col-on",switchKnobClass:"pz-good"===s.state.switchKnobClass?"pz-bad":"pz-good",switchKnobState:"1"===s.state.switchKnobState?"0":"1",state:"1"===s.state.switchKnobState?"0":"1",isOn:!("1"===s.state.switchKnobState.toString()),initiator:t.currentTarget};s.setState(e),s.handleStateChange(e)},s.state={state:d.switchKnobState,rootID:d.appRootID,fieldID:d.switchFieldID,fieldName:d.switchFieldName,switchKnobState:d.switchKnobState,switchOffOnClass:d.switchOffOnClass,switchKnobClass:d.switchKnobClass,magnification:d.magnification,isOn:"1"===d.switchKnobState||1===d.switchKnobState,initiator:"",activeMenuDefault:"pz-stronger",inactiveMenuDefault:"pz-default"},s.appRootID="widgetDataKey"in d?d.widgetDataKey:"values_choices",s.fieldName="fieldName"in d?d.fieldName:"personal_values",s.storeManager=new g("session","vuex"),s}return Object(u.a)(e,t),Object(r.a)(e,[{key:"componentDidMount",value:function(){var t=document.querySelector("#".concat(this.state.fieldID,"-t-setup"));f()(t).css({transform:"scale(".concat(this.state.magnification,")"),"transform-origin":"0 0"}),f()("#".concat(this.state.rootID)).css({display:"inline-block"})}},{key:"componentWillUnmount",value:function(){}},{key:"componentDidUpdate",value:function(){}},{key:"handleStateChange",value:function(t){var e="Categories"===t.pseudoType?f()("#pz-cats-ul"):f()("#pz-tags-ul");"Categories"===t.pseudoType?t.isOn?(this.props.updateMenuClass("activeMenuClassCats",this.state.activeMenuDefault),e.fadeIn(750)):(this.props.updateMenuClass("activeMenuClassCats",this.state.inactiveMenuDefault),e.fadeOut(750)):"Tags"===t.pseudoType&&(t.isOn?(this.props.updateMenuClass("activeMenuClassTags",this.state.activeMenuDefault),e.fadeIn(750),f()("#pz-tags-name-block").fadeIn(750)):(this.props.updateMenuClass("activeMenuClassTags",this.state.inactiveMenuDefault),e.fadeOut(750),f()("#pz-tags-name-block").fadeOut(750)))}},{key:"render",value:function(){var t=this;return i.a.createElement("div",{className:"pz-switch-wrapper ".concat(this.state.fieldID,"-t")},i.a.createElement("div",{className:"pz-switch-setup",id:"".concat(this.state.fieldID,"-t-setup")},i.a.createElement("div",{className:"pz-switch-box ".concat(this.state.switchOffOnClass),id:"pz-switch-knob-".concat(this.state.switchOffOnClass,"-t"),onClick:function(e){t.runClickAction(e)}},i.a.createElement("div",{className:"pz-switch-knob ".concat(this.state.switchKnobClass),"data-state":this.state.switchKnobState,"data-con":this.onOffColors.onColor,"data-coff":this.onOffColors.offColor}),i.a.createElement("input",{type:"hidden",className:"pz-choice-alt pz-choice-class-default ".concat(this.state.fieldName),name:this.state.fieldName,ref:this.state.fieldName,value:this.state.switchKnobState,id:this.state.fieldID}))))}}]),e}(i.a.Component)),w=function(t){function e(){return Object(c.a)(this,e),Object(l.a)(this,Object(h.a)(e).apply(this,arguments))}return Object(u.a)(e,t),Object(r.a)(e,[{key:"render",value:function(){return i.a.createElement(v,{switchFieldID:"pz-cats-menu",switchFieldName:"pz_cats_menu",updateMenuClass:this.updateMenuClass(),switchOffOnClass:"pz-col-on",switchKnobClass:"pz-good",switchKnobState:"1"})}},{key:"updateMenuClass",value:function(){return function(){}}}]),e}(i.a.Component);o.a.render(i.a.createElement(w,null),document.getElementById(d.appRootID))}},[[12,1,2]]]);
//# sourceMappingURL=main.778911e9.chunk.js.map