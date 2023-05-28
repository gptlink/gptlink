import{d as N,r as z,aU as Ct,aV as $t,h as l,aW as $e,g as B,i as r,aX as kt,k as x,u as We,s as Q,aY as zt,b as j,aZ as St,A as E,w as je,a_ as ce,a$ as Rt,a3 as Pt,c as Tt,o as Ee,b0 as Bt,b1 as At,S as ue,b2 as Lt,b3 as Wt,b4 as jt,b5 as Et,j as D,ax as It,b6 as Nt,b7 as ne,e as Ot,B as se,b8 as oe,L as re,p as Dt,t as H,b9 as Ht,at as Vt,ay as ke,ba as ze,f as J,a1 as Mt,a2 as Ft,bb as Ut,bc as Gt,bd as Xt,be as Yt,ad as Kt,C as G,P as ie,F as f,a4 as k,G as A,H as $,ar as le,E as L,aa as U,ap as Z,a9 as Se,I as Re,_ as be,Z as Pe,a8 as qt,D as fe,bf as Jt,a5 as Zt,J as Qt,K as ea}from"./index-6225040b.js";import{a as ta}from"./index-6572c092.js";const aa=$e(".v-x-scroll",{overflow:"auto",scrollbarWidth:"none"},[$e("&::-webkit-scrollbar",{width:0,height:0})]),na=N({name:"XScroll",props:{disabled:Boolean,onScroll:Function},setup(){const e=z(null);function n(o){!(o.currentTarget.offsetWidth<o.currentTarget.scrollWidth)||o.deltaY===0||(o.currentTarget.scrollLeft+=o.deltaY+o.deltaX,o.preventDefault())}const s=Ct();return aa.mount({id:"vueuc/x-scroll",head:!0,anchorMetaName:$t,ssr:s}),Object.assign({selfRef:e,handleWheel:n},{scrollTo(...o){var p;(p=e.value)===null||p===void 0||p.scrollTo(...o)}})},render(){return l("div",{ref:"selfRef",onScroll:this.onScroll,onWheel:this.disabled?void 0:this.handleWheel,class:"v-x-scroll"},this.$slots)}}),sa=N({name:"Add",render(){return l("svg",{width:"512",height:"512",viewBox:"0 0 512 512",fill:"none",xmlns:"http://www.w3.org/2000/svg"},l("path",{d:"M256 112V400M400 256H112",stroke:"currentColor","stroke-width":"32","stroke-linecap":"round","stroke-linejoin":"round"}))}}),oa=B([B("@keyframes spin-rotate",`
 from {
 transform: rotate(0);
 }
 to {
 transform: rotate(360deg);
 }
 `),r("spin-container",{position:"relative"},[r("spin-body",`
 position: absolute;
 top: 50%;
 left: 50%;
 transform: translateX(-50%) translateY(-50%);
 `,[kt()])]),r("spin-body",`
 display: inline-flex;
 align-items: center;
 justify-content: center;
 flex-direction: column;
 `),r("spin",`
 display: inline-flex;
 height: var(--n-size);
 width: var(--n-size);
 font-size: var(--n-size);
 color: var(--n-color);
 `,[x("rotate",`
 animation: spin-rotate 2s linear infinite;
 `)]),r("spin-description",`
 display: inline-block;
 font-size: var(--n-font-size);
 color: var(--n-text-color);
 transition: color .3s var(--n-bezier);
 margin-top: 8px;
 `),r("spin-content",`
 opacity: 1;
 transition: opacity .3s var(--n-bezier);
 pointer-events: all;
 `,[x("spinning",`
 user-select: none;
 -webkit-user-select: none;
 pointer-events: none;
 opacity: var(--n-opacity-spinning);
 `)])]),ra={small:20,medium:18,large:16},ia=Object.assign(Object.assign({},Q.props),{description:String,stroke:String,size:{type:[String,Number],default:"medium"},show:{type:Boolean,default:!0},strokeWidth:Number,rotate:{type:Boolean,default:!0},spinning:{type:Boolean,validator:()=>!0,default:void 0}}),la=N({name:"Spin",props:ia,setup(e){const{mergedClsPrefixRef:n,inlineThemeDisabled:s}=We(e),c=Q("Spin","-spin",oa,zt,e,n),o=j(()=>{const{size:i}=e,{common:{cubicBezierEaseInOut:u},self:v}=c.value,{opacitySpinning:h,color:T,textColor:_}=v,y=typeof i=="number"?St(i):v[E("size",i)];return{"--n-bezier":u,"--n-opacity-spinning":h,"--n-size":y,"--n-color":T,"--n-text-color":_}}),p=s?je("spin",j(()=>{const{size:i}=e;return typeof i=="number"?String(i):i[0]}),o,e):void 0;return{mergedClsPrefix:n,compitableShow:ce(e,["spinning","show"]),mergedStrokeWidth:j(()=>{const{strokeWidth:i}=e;if(i!==void 0)return i;const{size:u}=e;return ra[typeof u=="number"?"medium":u]}),cssVars:s?void 0:o,themeClass:p==null?void 0:p.themeClass,onRender:p==null?void 0:p.onRender}},render(){var e,n;const{$slots:s,mergedClsPrefix:c,description:o}=this,p=s.icon&&this.rotate,i=(o||s.description)&&l("div",{class:`${c}-spin-description`},o||((e=s.description)===null||e===void 0?void 0:e.call(s))),u=s.icon?l("div",{class:[`${c}-spin-body`,this.themeClass]},l("div",{class:[`${c}-spin`,p&&`${c}-spin--rotate`],style:s.default?"":this.cssVars},s.icon()),i):l("div",{class:[`${c}-spin-body`,this.themeClass]},l(Rt,{clsPrefix:c,style:s.default?"":this.cssVars,stroke:this.stroke,"stroke-width":this.mergedStrokeWidth,class:`${c}-spin`}),i);return(n=this.onRender)===null||n===void 0||n.call(this),s.default?l("div",{class:[`${c}-spin-container`,this.themeClass],style:this.cssVars},l("div",{class:[`${c}-spin-content`,this.compitableShow&&`${c}-spin-content--spinning`]},s),l(Pt,{name:"fade-in-transition"},{default:()=>this.compitableShow?u:null})):u}}),ve=Tt("n-tabs"),Ie={tab:[String,Number,Object,Function],name:{type:[String,Number],required:!0},disabled:Boolean,displayDirective:{type:String,default:"if"},closable:{type:Boolean,default:void 0},tabProps:Object,label:[String,Number,Object,Function]},Te=N({__TAB_PANE__:!0,name:"TabPane",alias:["TabPanel"],props:Ie,setup(e){const n=Ee(ve,null);return n||Bt("tab-pane","`n-tab-pane` must be placed inside `n-tabs`."),{style:n.paneStyleRef,class:n.paneClassRef,mergedClsPrefix:n.mergedClsPrefixRef}},render(){return l("div",{class:[`${this.mergedClsPrefix}-tab-pane`,this.class],style:this.style},this.$slots)}}),da=Object.assign({internalLeftPadded:Boolean,internalAddable:Boolean,internalCreatedByPane:Boolean},Et(Ie,["displayDirective"])),pe=N({__TAB__:!0,inheritAttrs:!1,name:"Tab",props:da,setup(e){const{mergedClsPrefixRef:n,valueRef:s,typeRef:c,closableRef:o,tabStyleRef:p,tabChangeIdRef:i,onBeforeLeaveRef:u,triggerRef:v,handleAdd:h,activateTab:T,handleClose:_}=Ee(ve);return{trigger:v,mergedClosable:j(()=>{if(e.internalAddable)return!1;const{closable:y}=e;return y===void 0?o.value:y}),style:p,clsPrefix:n,value:s,type:c,handleClose(y){y.stopPropagation(),!e.disabled&&_(e.name)},activateTab(){if(e.disabled)return;if(e.internalAddable){h();return}const{name:y}=e,S=++i.id;if(y!==s.value){const{value:R}=u;R?Promise.resolve(R(e.name,s.value)).then(C=>{C&&i.id===S&&T(y)}):T(y)}}}},render(){const{internalAddable:e,clsPrefix:n,name:s,disabled:c,label:o,tab:p,value:i,mergedClosable:u,style:v,trigger:h,$slots:{default:T}}=this,_=o??p;return l("div",{class:`${n}-tabs-tab-wrapper`},this.internalLeftPadded?l("div",{class:`${n}-tabs-tab-pad`}):null,l("div",Object.assign({key:s,"data-name":s,"data-disabled":c?!0:void 0},At({class:[`${n}-tabs-tab`,i===s&&`${n}-tabs-tab--active`,c&&`${n}-tabs-tab--disabled`,u&&`${n}-tabs-tab--closable`,e&&`${n}-tabs-tab--addable`],onClick:h==="click"?this.activateTab:void 0,onMouseenter:h==="hover"?this.activateTab:void 0,style:e?void 0:v},this.internalCreatedByPane?this.tabProps||{}:this.$attrs)),l("span",{class:`${n}-tabs-tab__label`},e?l(ue,null,l("div",{class:`${n}-tabs-tab__height-placeholder`}," "),l(Lt,{clsPrefix:n},{default:()=>l(sa,null)})):T?T():typeof _=="object"?_:Wt(_??s)),u&&this.type==="card"?l(jt,{clsPrefix:n,class:`${n}-tabs-tab__close`,onClick:this.handleClose,disabled:c}):null))}}),ca=r("tabs",`
 box-sizing: border-box;
 width: 100%;
 display: flex;
 flex-direction: column;
 transition:
 background-color .3s var(--n-bezier),
 border-color .3s var(--n-bezier);
`,[x("segment-type",[r("tabs-rail",[B("&.transition-disabled","color: red;",[r("tabs-tab",`
 transition: none;
 `)])])]),x("left, right",`
 flex-direction: row;
 `,[r("tabs-bar",`
 width: 2px;
 right: 0;
 transition:
 top .2s var(--n-bezier),
 max-height .2s var(--n-bezier),
 background-color .3s var(--n-bezier);
 `),r("tabs-tab",`
 padding: var(--n-tab-padding-vertical); 
 `)]),x("right",`
 flex-direction: row-reverse;
 `,[r("tabs-bar",`
 left: 0;
 `)]),x("bottom",`
 flex-direction: column-reverse;
 justify-content: flex-end;
 `,[r("tabs-bar",`
 top: 0;
 `)]),r("tabs-rail",`
 padding: 3px;
 border-radius: var(--n-tab-border-radius);
 width: 100%;
 background-color: var(--n-color-segment);
 transition: background-color .3s var(--n-bezier);
 display: flex;
 align-items: center;
 `,[r("tabs-tab-wrapper",`
 flex-basis: 0;
 flex-grow: 1;
 display: flex;
 align-items: center;
 justify-content: center;
 `,[r("tabs-tab",`
 overflow: hidden;
 border-radius: var(--n-tab-border-radius);
 width: 100%;
 display: flex;
 align-items: center;
 justify-content: center;
 `,[x("active",`
 font-weight: var(--n-font-weight-strong);
 color: var(--n-tab-text-color-active);
 background-color: var(--n-tab-color-segment);
 box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .08);
 `),B("&:hover",`
 color: var(--n-tab-text-color-hover);
 `)])])]),x("flex",[r("tabs-nav",{width:"100%"},[r("tabs-wrapper",{width:"100%"},[r("tabs-tab",{marginRight:0})])])]),r("tabs-nav",`
 box-sizing: border-box;
 line-height: 1.5;
 display: flex;
 transition: border-color .3s var(--n-bezier);
 `,[D("prefix, suffix",`
 display: flex;
 align-items: center;
 `),D("prefix","padding-right: 16px;"),D("suffix","padding-left: 16px;")]),r("tabs-nav-scroll-wrapper",`
 flex: 1;
 position: relative;
 overflow: hidden;
 `,[x("shadow-before",[B("&::before",`
 box-shadow: inset 10px 0 8px -8px rgba(0, 0, 0, .12);
 `)]),x("shadow-after",[B("&::after",`
 box-shadow: inset -10px 0 8px -8px rgba(0, 0, 0, .12);
 `)]),r("tabs-nav-y-scroll",`
 height: 100%;
 width: 100%;
 overflow-y: auto; 
 scrollbar-width: none;
 `,[B("&::-webkit-scrollbar",`
 width: 0;
 height: 0;
 `)]),B("&::before, &::after",`
 transition: box-shadow .3s var(--n-bezier);
 pointer-events: none;
 content: "";
 position: absolute;
 top: 0;
 bottom: 0;
 width: 20px;
 z-index: 1;
 `),B("&::before",`
 left: 0;
 `),B("&::after",`
 right: 0;
 `)]),r("tabs-nav-scroll-content",`
 display: flex;
 position: relative;
 min-width: 100%;
 width: fit-content;
 `),r("tabs-wrapper",`
 display: inline-flex;
 flex-wrap: nowrap;
 position: relative;
 `),r("tabs-tab-wrapper",`
 display: flex;
 flex-wrap: nowrap;
 flex-shrink: 0;
 flex-grow: 0;
 `),r("tabs-tab",`
 cursor: pointer;
 white-space: nowrap;
 flex-wrap: nowrap;
 display: inline-flex;
 align-items: center;
 color: var(--n-tab-text-color);
 font-size: var(--n-tab-font-size);
 background-clip: padding-box;
 padding: var(--n-tab-padding);
 transition:
 box-shadow .3s var(--n-bezier),
 color .3s var(--n-bezier),
 background-color .3s var(--n-bezier),
 border-color .3s var(--n-bezier);
 `,[x("disabled",{cursor:"not-allowed"}),D("close",`
 margin-left: 6px;
 transition:
 background-color .3s var(--n-bezier),
 color .3s var(--n-bezier);
 `),D("label",`
 display: flex;
 align-items: center;
 `)]),r("tabs-bar",`
 position: absolute;
 bottom: 0;
 height: 2px;
 border-radius: 1px;
 background-color: var(--n-bar-color);
 transition:
 left .2s var(--n-bezier),
 max-width .2s var(--n-bezier),
 background-color .3s var(--n-bezier);
 `,[B("&.transition-disabled",`
 transition: none;
 `),x("disabled",`
 background-color: var(--n-tab-text-color-disabled)
 `)]),r("tabs-pane-wrapper",`
 position: relative;
 overflow: hidden;
 transition: max-height .2s var(--n-bezier);
 `),r("tab-pane",`
 color: var(--n-pane-text-color);
 width: 100%;
 padding: var(--n-pane-padding);
 transition:
 color .3s var(--n-bezier),
 background-color .3s var(--n-bezier),
 opacity .2s var(--n-bezier);
 left: 0;
 right: 0;
 top: 0;
 `,[B("&.next-transition-leave-active, &.prev-transition-leave-active, &.next-transition-enter-active, &.prev-transition-enter-active",`
 transition:
 color .3s var(--n-bezier),
 background-color .3s var(--n-bezier),
 transform .2s var(--n-bezier),
 opacity .2s var(--n-bezier);
 `),B("&.next-transition-leave-active, &.prev-transition-leave-active",`
 position: absolute;
 `),B("&.next-transition-enter-from, &.prev-transition-leave-to",`
 transform: translateX(32px);
 opacity: 0;
 `),B("&.next-transition-leave-to, &.prev-transition-enter-from",`
 transform: translateX(-32px);
 opacity: 0;
 `),B("&.next-transition-leave-from, &.next-transition-enter-to, &.prev-transition-leave-from, &.prev-transition-enter-to",`
 transform: translateX(0);
 opacity: 1;
 `)]),r("tabs-tab-pad",`
 width: var(--n-tab-gap);
 flex-grow: 0;
 flex-shrink: 0;
 `),x("line-type, bar-type",[r("tabs-tab",`
 font-weight: var(--n-tab-font-weight);
 box-sizing: border-box;
 vertical-align: bottom;
 `,[B("&:hover",{color:"var(--n-tab-text-color-hover)"}),x("active",`
 color: var(--n-tab-text-color-active);
 font-weight: var(--n-tab-font-weight-active);
 `),x("disabled",{color:"var(--n-tab-text-color-disabled)"})])]),r("tabs-nav",[x("line-type",[D("prefix, suffix",`
 transition: border-color .3s var(--n-bezier);
 border-bottom: 1px solid var(--n-tab-border-color);
 `),r("tabs-nav-scroll-content",`
 transition: border-color .3s var(--n-bezier);
 border-bottom: 1px solid var(--n-tab-border-color);
 `),r("tabs-bar",`
 border-radius: 0;
 bottom: -1px;
 `)]),x("card-type",[D("prefix, suffix",`
 transition: border-color .3s var(--n-bezier);
 border-bottom: 1px solid var(--n-tab-border-color);
 `),r("tabs-pad",`
 flex-grow: 1;
 transition: border-color .3s var(--n-bezier);
 border-bottom: 1px solid var(--n-tab-border-color);
 `),r("tabs-tab-pad",`
 transition: border-color .3s var(--n-bezier);
 border-bottom: 1px solid var(--n-tab-border-color);
 `),r("tabs-tab",`
 font-weight: var(--n-tab-font-weight);
 border: 1px solid var(--n-tab-border-color);
 border-top-left-radius: var(--n-tab-border-radius);
 border-top-right-radius: var(--n-tab-border-radius);
 background-color: var(--n-tab-color);
 box-sizing: border-box;
 position: relative;
 vertical-align: bottom;
 display: flex;
 justify-content: space-between;
 font-size: var(--n-tab-font-size);
 color: var(--n-tab-text-color);
 `,[x("addable",`
 padding-left: 8px;
 padding-right: 8px;
 font-size: 16px;
 `,[D("height-placeholder",`
 width: 0;
 font-size: var(--n-tab-font-size);
 `),It("disabled",[B("&:hover",`
 color: var(--n-tab-text-color-hover);
 `)])]),x("closable","padding-right: 6px;"),x("active",`
 border-bottom: 1px solid #0000;
 background-color: #0000;
 font-weight: var(--n-tab-font-weight-active);
 color: var(--n-tab-text-color-active);
 `),x("disabled","color: var(--n-tab-text-color-disabled);")]),r("tabs-scroll-padding","border-bottom: 1px solid var(--n-tab-border-color);")]),x("left, right",[r("tabs-wrapper",`
 flex-direction: column;
 `,[r("tabs-tab-wrapper",`
 flex-direction: column;
 `,[r("tabs-tab-pad",`
 height: var(--n-tab-gap);
 width: 100%;
 `)])]),r("tabs-nav-scroll-content",`
 border-bottom: none;
 `)]),x("left",[r("tabs-nav-scroll-content",`
 box-sizing: border-box;
 border-right: 1px solid var(--n-tab-border-color);
 `)]),x("right",[r("tabs-nav-scroll-content",`
 border-left: 1px solid var(--n-tab-border-color);
 `)]),x("bottom",[r("tabs-nav-scroll-content",`
 border-top: 1px solid var(--n-tab-border-color);
 border-bottom: none;
 `)])])]),ua=Object.assign(Object.assign({},Q.props),{value:[String,Number],defaultValue:[String,Number],trigger:{type:String,default:"click"},type:{type:String,default:"bar"},closable:Boolean,justifyContent:String,size:{type:String,default:"medium"},placement:{type:String,default:"top"},tabStyle:[String,Object],barWidth:Number,paneClass:String,paneStyle:[String,Object],addable:[Boolean,Object],tabsPadding:{type:Number,default:0},animated:Boolean,onBeforeLeave:Function,onAdd:Function,"onUpdate:value":[Function,Array],onUpdateValue:[Function,Array],onClose:[Function,Array],labelSize:String,activeName:[String,Number],onActiveNameChange:[Function,Array]}),ba=N({name:"Tabs",props:ua,setup(e,{slots:n}){var s,c,o,p;const{mergedClsPrefixRef:i,inlineThemeDisabled:u}=We(e),v=Q("Tabs","-tabs",ca,Nt,e,i),h=z(null),T=z(null),_=z(null),y=z(null),S=z(null),R=z(!0),C=z(!0),m=ce(e,["labelSize","size"]),w=ce(e,["activeName","value"]),g=z((c=(s=w.value)!==null&&s!==void 0?s:e.defaultValue)!==null&&c!==void 0?c:n.default?(p=(o=ne(n.default())[0])===null||o===void 0?void 0:o.props)===null||p===void 0?void 0:p.name:null),P=Ot(w,g),V={id:0},Ne=j(()=>{if(!(!e.justifyContent||e.type==="card"))return{display:"flex",justifyContent:e.justifyContent}});se(P,()=>{V.id=0,X(),ge()});function ee(){var t;const{value:a}=P;return a===null?null:(t=h.value)===null||t===void 0?void 0:t.querySelector(`[data-name="${a}"]`)}function Oe(t){if(e.type==="card")return;const{value:a}=T;if(a&&t){const d=`${i.value}-tabs-bar--disabled`,{barWidth:b,placement:I}=e;if(t.dataset.disabled==="true"?a.classList.add(d):a.classList.remove(d),["top","bottom"].includes(I)){if(he(["top","maxHeight","height"]),typeof b=="number"&&t.offsetWidth>=b){const W=Math.floor((t.offsetWidth-b)/2)+t.offsetLeft;a.style.left=`${W}px`,a.style.maxWidth=`${b}px`}else a.style.left=`${t.offsetLeft}px`,a.style.maxWidth=`${t.offsetWidth}px`;a.style.width="8192px",a.offsetWidth}else{if(he(["left","maxWidth","width"]),typeof b=="number"&&t.offsetHeight>=b){const W=Math.floor((t.offsetHeight-b)/2)+t.offsetTop;a.style.top=`${W}px`,a.style.maxHeight=`${b}px`}else a.style.top=`${t.offsetTop}px`,a.style.maxHeight=`${t.offsetHeight}px`;a.style.height="8192px",a.offsetHeight}}}function he(t){const{value:a}=T;if(a)for(const d of t)a.style[d]=""}function X(){if(e.type==="card")return;const t=ee();t&&Oe(t)}function ge(t){var a;const d=(a=S.value)===null||a===void 0?void 0:a.$el;if(!d)return;const b=ee();if(!b)return;const{scrollLeft:I,offsetWidth:W}=d,{offsetLeft:F,offsetWidth:q}=b;I>F?d.scrollTo({top:0,left:F,behavior:"smooth"}):F+q>I+W&&d.scrollTo({top:0,left:F+q-W,behavior:"smooth"})}const Y=z(null);let te=0,O=null;function De(t){const a=Y.value;if(a){te=t.getBoundingClientRect().height;const d=`${te}px`,b=()=>{a.style.height=d,a.style.maxHeight=d};O?(b(),O(),O=null):O=b}}function He(t){const a=Y.value;if(a){const d=t.getBoundingClientRect().height,b=()=>{document.body.offsetHeight,a.style.maxHeight=`${d}px`,a.style.height=`${Math.max(te,d)}px`};O?(O(),O=null,b()):O=b}}function Ve(){const t=Y.value;t&&(t.style.maxHeight="",t.style.height="")}const me={value:[]},xe=z("next");function Me(t){const a=P.value;let d="next";for(const b of me.value){if(b===a)break;if(b===t){d="prev";break}}xe.value=d,Fe(t)}function Fe(t){const{onActiveNameChange:a,onUpdateValue:d,"onUpdate:value":b}=e;a&&J(a,t),d&&J(d,t),b&&J(b,t),g.value=t}function Ue(t){const{onClose:a}=e;a&&J(a,t)}function ye(){const{value:t}=T;if(!t)return;const a="transition-disabled";t.classList.add(a),X(),t.classList.remove(a)}let we=0;function Ge(t){var a;if(t.contentRect.width===0&&t.contentRect.height===0||we===t.contentRect.width)return;we=t.contentRect.width;const{type:d}=e;(d==="line"||d==="bar")&&ye(),d!=="segment"&&ae((a=S.value)===null||a===void 0?void 0:a.$el)}const Xe=oe(Ge,64);se([()=>e.justifyContent,()=>e.size],()=>{re(()=>{const{type:t}=e;(t==="line"||t==="bar")&&ye()})});const K=z(!1);function Ye(t){var a;const{target:d,contentRect:{width:b}}=t,I=d.parentElement.offsetWidth;if(!K.value)I<b&&(K.value=!0);else{const{value:W}=y;if(!W)return;I-b>W.$el.offsetWidth&&(K.value=!1)}ae((a=S.value)===null||a===void 0?void 0:a.$el)}const Ke=oe(Ye,64);function qe(){const{onAdd:t}=e;t&&t(),re(()=>{const a=ee(),{value:d}=S;!a||!d||d.scrollTo({left:a.offsetLeft,top:0,behavior:"smooth"})})}function ae(t){if(!t)return;const{scrollLeft:a,scrollWidth:d,offsetWidth:b}=t;R.value=a<=0,C.value=a+b>=d}const Je=oe(t=>{ae(t.target)},64);Dt(ve,{triggerRef:H(e,"trigger"),tabStyleRef:H(e,"tabStyle"),paneClassRef:H(e,"paneClass"),paneStyleRef:H(e,"paneStyle"),mergedClsPrefixRef:i,typeRef:H(e,"type"),closableRef:H(e,"closable"),valueRef:P,tabChangeIdRef:V,onBeforeLeaveRef:H(e,"onBeforeLeave"),activateTab:Me,handleClose:Ue,handleAdd:qe}),Ht(()=>{X(),ge()}),Vt(()=>{const{value:t}=_;if(!t||["left","right"].includes(e.placement))return;const{value:a}=i,d=`${a}-tabs-nav-scroll-wrapper--shadow-before`,b=`${a}-tabs-nav-scroll-wrapper--shadow-after`;R.value?t.classList.remove(d):t.classList.add(d),C.value?t.classList.remove(b):t.classList.add(b)});const _e=z(null);se(P,()=>{if(e.type==="segment"){const t=_e.value;t&&re(()=>{t.classList.add("transition-disabled"),t.offsetWidth,t.classList.remove("transition-disabled")})}});const Ze={syncBarPosition:()=>{X()}},Ce=j(()=>{const{value:t}=m,{type:a}=e,d={card:"Card",bar:"Bar",line:"Line",segment:"Segment"}[a],b=`${t}${d}`,{self:{barColor:I,closeIconColor:W,closeIconColorHover:F,closeIconColorPressed:q,tabColor:Qe,tabBorderColor:et,paneTextColor:tt,tabFontWeight:at,tabBorderRadius:nt,tabFontWeightActive:st,colorSegment:ot,fontWeightStrong:rt,tabColorSegment:it,closeSize:lt,closeIconSize:dt,closeColorHover:ct,closeColorPressed:ut,closeBorderRadius:bt,[E("panePadding",t)]:ft,[E("tabPadding",b)]:pt,[E("tabPaddingVertical",b)]:vt,[E("tabGap",b)]:ht,[E("tabTextColor",a)]:gt,[E("tabTextColorActive",a)]:mt,[E("tabTextColorHover",a)]:xt,[E("tabTextColorDisabled",a)]:yt,[E("tabFontSize",t)]:wt},common:{cubicBezierEaseInOut:_t}}=v.value;return{"--n-bezier":_t,"--n-color-segment":ot,"--n-bar-color":I,"--n-tab-font-size":wt,"--n-tab-text-color":gt,"--n-tab-text-color-active":mt,"--n-tab-text-color-disabled":yt,"--n-tab-text-color-hover":xt,"--n-pane-text-color":tt,"--n-tab-border-color":et,"--n-tab-border-radius":nt,"--n-close-size":lt,"--n-close-icon-size":dt,"--n-close-color-hover":ct,"--n-close-color-pressed":ut,"--n-close-border-radius":bt,"--n-close-icon-color":W,"--n-close-icon-color-hover":F,"--n-close-icon-color-pressed":q,"--n-tab-color":Qe,"--n-tab-font-weight":at,"--n-tab-font-weight-active":st,"--n-tab-padding":pt,"--n-tab-padding-vertical":vt,"--n-tab-gap":ht,"--n-pane-padding":ft,"--n-font-weight-strong":rt,"--n-tab-color-segment":it}}),M=u?je("tabs",j(()=>`${m.value[0]}${e.type[0]}`),Ce,e):void 0;return Object.assign({mergedClsPrefix:i,mergedValue:P,renderedNames:new Set,tabsRailElRef:_e,tabsPaneWrapperRef:Y,tabsElRef:h,barElRef:T,addTabInstRef:y,xScrollInstRef:S,scrollWrapperElRef:_,addTabFixed:K,tabWrapperStyle:Ne,handleNavResize:Xe,mergedSize:m,handleScroll:Je,handleTabsResize:Ke,cssVars:u?void 0:Ce,themeClass:M==null?void 0:M.themeClass,animationDirection:xe,renderNameListRef:me,onAnimationBeforeLeave:De,onAnimationEnter:He,onAnimationAfterEnter:Ve,onRender:M==null?void 0:M.onRender},Ze)},render(){const{mergedClsPrefix:e,type:n,placement:s,addTabFixed:c,addable:o,mergedSize:p,renderNameListRef:i,onRender:u,$slots:{default:v,prefix:h,suffix:T}}=this;u==null||u();const _=v?ne(v()).filter(g=>g.type.__TAB_PANE__===!0):[],y=v?ne(v()).filter(g=>g.type.__TAB__===!0):[],S=!y.length,R=n==="card",C=n==="segment",m=!R&&!C&&this.justifyContent;i.value=[];const w=()=>{const g=l("div",{style:this.tabWrapperStyle,class:[`${e}-tabs-wrapper`]},m?null:l("div",{class:`${e}-tabs-scroll-padding`,style:{width:`${this.tabsPadding}px`}}),S?_.map((P,V)=>(i.value.push(P.props.name),de(l(pe,Object.assign({},P.props,{internalCreatedByPane:!0,internalLeftPadded:V!==0&&(!m||m==="center"||m==="start"||m==="end")}),P.children?{default:P.children.tab}:void 0)))):y.map((P,V)=>(i.value.push(P.props.name),de(V!==0&&!m?Le(P):P))),!c&&o&&R?Ae(o,(S?_.length:y.length)!==0):null,m?null:l("div",{class:`${e}-tabs-scroll-padding`,style:{width:`${this.tabsPadding}px`}}));return l("div",{ref:"tabsElRef",class:`${e}-tabs-nav-scroll-content`},R&&o?l(ze,{onResize:this.handleTabsResize},{default:()=>g}):g,R?l("div",{class:`${e}-tabs-pad`}):null,R?null:l("div",{ref:"barElRef",class:`${e}-tabs-bar`}))};return l("div",{class:[`${e}-tabs`,this.themeClass,`${e}-tabs--${n}-type`,`${e}-tabs--${p}-size`,m&&`${e}-tabs--flex`,`${e}-tabs--${s}`],style:this.cssVars},l("div",{class:[`${e}-tabs-nav--${n}-type`,`${e}-tabs-nav--${s}`,`${e}-tabs-nav`]},ke(h,g=>g&&l("div",{class:`${e}-tabs-nav__prefix`},g)),C?l("div",{class:`${e}-tabs-rail`,ref:"tabsRailElRef"},S?_.map((g,P)=>(i.value.push(g.props.name),l(pe,Object.assign({},g.props,{internalCreatedByPane:!0,internalLeftPadded:P!==0}),g.children?{default:g.children.tab}:void 0))):y.map((g,P)=>(i.value.push(g.props.name),P===0?g:Le(g)))):l(ze,{onResize:this.handleNavResize},{default:()=>l("div",{class:`${e}-tabs-nav-scroll-wrapper`,ref:"scrollWrapperElRef"},["top","bottom"].includes(s)?l(na,{ref:"xScrollInstRef",onScroll:this.handleScroll},{default:w}):l("div",{class:`${e}-tabs-nav-y-scroll`},w()))}),c&&o&&R?Ae(o,!0):null,ke(T,g=>g&&l("div",{class:`${e}-tabs-nav__suffix`},g))),S&&(this.animated?l("div",{ref:"tabsPaneWrapperRef",class:`${e}-tabs-pane-wrapper`},Be(_,this.mergedValue,this.renderedNames,this.onAnimationBeforeLeave,this.onAnimationEnter,this.onAnimationAfterEnter,this.animationDirection)):Be(_,this.mergedValue,this.renderedNames)))}});function Be(e,n,s,c,o,p,i){const u=[];return e.forEach(v=>{const{name:h,displayDirective:T,"display-directive":_}=v.props,y=R=>T===R||_===R,S=n===h;if(v.key!==void 0&&(v.key=h),S||y("show")||y("show:lazy")&&s.has(h)){s.has(h)||s.add(h);const R=!y("if");u.push(R?Mt(v,[[Ft,S]]):v)}}),i?l(Ut,{name:`${i}-transition`,onBeforeLeave:c,onEnter:o,onAfterEnter:p},{default:()=>u}):u}function Ae(e,n){return l(pe,{ref:"addTabInstRef",key:"__addable",name:"__addable",internalCreatedByPane:!0,internalAddable:!0,internalLeftPadded:n,disabled:typeof e=="object"&&e.disabled})}function Le(e){const n=Gt(e);return n.props?n.props.internalLeftPadded=!0:n.props={internalLeftPadded:!0},n}function de(e){return Array.isArray(e.dynamicProps)?e.dynamicProps.includes("internalLeftPadded")||e.dynamicProps.push("internalLeftPadded"):e.dynamicProps=["internalLeftPadded"],e}const fa={class:"p-4 space-y-5 min-h-[200px]"},pa={class:"space-y-6"},va={class:"flex items-center space-x-4"},ha={class:"flex-shrink-0 w-[100px]"},ga={class:"flex-1"},ma={class:"flex items-center space-x-4"},xa={class:"flex-shrink-0 w-[100px]"},ya={class:"w-[200px]"},wa={class:"flex items-center space-x-4"},_a={class:"flex-shrink-0 w-[100px]"},Ca={class:"flex-1"},$a={class:"flex items-center space-x-4"},ka={class:"flex-shrink-0 w-[100px]"},za={class:"flex items-center space-x-4"},Sa={class:"flex-shrink-0 w-[100px]"},Ra={class:"flex items-center space-x-4"},Pa=["onClick"],Ta={class:"text-xl"},Ba={class:"flex items-center space-x-4"},Aa={class:"flex-shrink-0 w-[100px]"},La={class:"flex items-center space-x-4"},Wa=["onClick"],ja={class:"text-sm"},Ea=N({__name:"General",emits:["update"],setup(e,{emit:n}){const s=Xt(),c=Yt(),o=Kt(),p=j(()=>s.theme),i=j(()=>c.userInfo),u=z(i.value.avatar??""),v=z(i.value.name??""),h=z(i.value.description??""),T=j({get(){return s.language},set(C){s.setLanguage(C)}}),_=[{label:"Auto",key:"auto",icon:"ri:contrast-line"},{label:"Light",key:"light",icon:"ri:sun-foggy-line"},{label:"Dark",key:"dark",icon:"ri:moon-foggy-line"}],y=[{label:"中文",key:"zh-CN",value:"zh-CN"},{label:"English",key:"en-US",value:"en-US"}];function S(C){c.updateUserInfo(C),o.success(Pe("common.success"))}function R(){c.resetUserInfo(),o.success(Pe("common.success")),n("update")}return(C,m)=>(G(),ie("div",fa,[f("div",pa,[f("div",va,[f("span",ha,k(C.$t("setting.avatarLink")),1),f("div",ga,[A($(le),{value:u.value,"onUpdate:value":m[0]||(m[0]=w=>u.value=w),placeholder:""},null,8,["value"])]),A($(Z),{size:"tiny",text:"",type:"primary",onClick:m[1]||(m[1]=w=>S({avatar:u.value}))},{default:L(()=>[U(k(C.$t("common.save")),1)]),_:1})]),f("div",ma,[f("span",xa,k(C.$t("setting.name")),1),f("div",ya,[A($(le),{value:v.value,"onUpdate:value":m[2]||(m[2]=w=>v.value=w),placeholder:""},null,8,["value"])]),A($(Z),{size:"tiny",text:"",type:"primary",onClick:m[3]||(m[3]=w=>S({name:v.value}))},{default:L(()=>[U(k(C.$t("common.save")),1)]),_:1})]),f("div",wa,[f("span",_a,k(C.$t("setting.description")),1),f("div",Ca,[A($(le),{value:h.value,"onUpdate:value":m[4]||(m[4]=w=>h.value=w),placeholder:""},null,8,["value"])]),A($(Z),{size:"tiny",text:"",type:"primary",onClick:m[5]||(m[5]=w=>S({description:h.value}))},{default:L(()=>[U(k(C.$t("common.save")),1)]),_:1})]),f("div",$a,[f("span",ka,k(C.$t("setting.resetUserInfo")),1),A($(Z),{text:"",type:"primary",onClick:R},{default:L(()=>[U(k(C.$t("common.reset")),1)]),_:1})]),f("div",za,[f("span",Sa,k(C.$t("setting.theme")),1),f("div",Ra,[(G(),ie(ue,null,Se(_,w=>f("a",{key:w.key,class:Re(["flex items-center justify-center h-8 px-4 border rounded-md cursor-pointer dark:border-neutral-700",w.key===$(p)&&["bg-[#4ca85e]","border-[#4ca85e]","text-white"]]),onClick:g=>$(s).setTheme(w.key)},[f("span",Ta,[A($(be),{icon:w.icon},null,8,["icon"])])],10,Pa)),64))])]),f("div",Ba,[f("span",Aa,k(C.$t("setting.language")),1),f("div",La,[(G(),ie(ue,null,Se(y,w=>f("a",{key:w.key,class:Re(["flex items-center justify-center h-8 px-4 border rounded-md cursor-pointer dark:border-neutral-700",w.key===$(T)&&["bg-[#4ca85e]","border-[#4ca85e]","text-white"]]),onClick:g=>$(s).setLanguage(w.key)},[f("span",ja,k(w.label),1)],10,Wa)),64))])])])]))}}),Ia="chatgpt-web",Na="2.9.3",Oa="AIyaaa",Da="AIyaaa <AIyaaa1994@gmail.com>",Ha=["chatgpt-web","chatgpt","chatbot","vue"],Va={dev:"vite",build:"run-p build-only",preview:"vite preview","build-only":"vite build","type-check":"vue-tsc --noEmit",lint:"eslint .","lint:fix":"eslint . --fix",bootstrap:"pnpm install && pnpm run common:prepare","common:cleanup":"rimraf node_modules && rimraf pnpm-lock.yaml","common:prepare":"husky install"},Ma={"@cblink/web-user-login":"0.3.10","@traptitech/markdown-it-katex":"^3.6.0","@vueuse/core":"^9.13.0","better-scroll":"^2.5.1","element-plus":"^2.3.0","highlight.js":"^11.7.0",html2canvas:"^1.4.1","js-cookie":"^3.0.5",katex:"^0.16.4","markdown-it":"^13.0.1","naive-ui":"^2.34.3",pinia:"^2.0.32","qrcode.vue":"^3.3.4",vue:"^3.2.47","vue-i18n":"^9.2.2","vue-router":"^4.1.6","weixin-js-sdk":"^1.6.0"},Fa={"@antfu/eslint-config":"^0.35.3","@commitlint/cli":"^17.4.4","@commitlint/config-conventional":"^17.4.4","@iconify/vue":"^4.1.0","@types/crypto-js":"^4.1.1","@types/katex":"^0.16.0","@types/markdown-it":"^12.2.3","@types/node":"^18.14.6","@vitejs/plugin-vue":"^4.0.0","aegis-web-sdk":"^1.37.1",autoprefixer:"^10.4.13",axios:"^1.3.4","crypto-js":"^4.1.1",eslint:"^8.35.0",husky:"^8.0.3","jweixin-module":"^1.6.0",less:"^4.1.3","lint-staged":"^13.1.2",lodash:"^4.17.21","npm-run-all":"^4.1.5",postcss:"^8.4.21",rimraf:"^4.2.0",sass:"^1.59.2",tailwindcss:"^3.2.7",typescript:"~4.9.5",vite:"^4.1.4","vue-tsc":"^1.2.0"},Ua={name:Ia,version:Na,private:!0,description:Oa,author:Da,keywords:Ha,scripts:Va,dependencies:Ma,devDependencies:Fa,"lint-staged":{"*.{ts,tsx,vue}":["pnpm lint:fix"]}},Ga={class:"p-4 space-y-4"},Xa={class:"text-xl font-bold"},Ya=f("div",{class:"p-2 space-y-2 rounded-md bg-neutral-100 dark:bg-neutral-700"},[f("p",null,[U(" 此项目开源于 "),f("a",{class:"text-blue-600 dark:text-blue-500",href:"https://github.com/Chanzhaoyu/chatgpt-web",target:"_blank"}," Github "),U(" ，免费且基于 MIT 协议，没有任何形式的付费行为！ ")]),f("p",null," 如果你觉得此项目对你有帮助，请在 Github 帮我点个 Star 或者给予一点赞助，谢谢！ ")],-1),Ka=N({__name:"About",setup(e){const n=z(!1),s=z();async function c(){try{n.value=!0;const{data:o}=await ta();s.value=o}finally{n.value=!1}}return qt(()=>{c()}),(o,p)=>(G(),fe($(la),{show:n.value},{default:L(()=>{var i,u,v,h;return[f("div",Ga,[f("h2",Xa," Version - "+k($(Ua).version),1),Ya,f("p",null,k(o.$t("setting.api"))+"："+k(((i=s.value)==null?void 0:i.apiModel)??"-"),1),f("p",null,k(o.$t("setting.reverseProxy"))+"："+k(((u=s.value)==null?void 0:u.reverseProxy)??"-"),1),f("p",null,k(o.$t("setting.timeout"))+"："+k(((v=s.value)==null?void 0:v.timeoutMs)??"-"),1),f("p",null,k(o.$t("setting.socks"))+"："+k(((h=s.value)==null?void 0:h.socksProxy)??"-"),1)])]}),_:1},8,["show"]))}}),qa={class:"ml-2"},Ja={class:"min-h-[100px]"},Za={class:"ml-2"},tn=N({__name:"index",props:{visible:{type:Boolean}},emits:["update:visible"],setup(e,{emit:n}){const s=e,c=z("General"),o=z(!1),p=j({get(){return s.visible},set(u){n("update:visible",u)}});function i(){o.value=!0,setTimeout(()=>{o.value=!1},0)}return(u,v)=>(G(),fe($(ea),{show:$(p),"onUpdate:show":v[1]||(v[1]=h=>Qt(p)?p.value=h:null),"auto-focus":!1},{default:L(()=>[A($(Jt),{role:"dialog","aria-modal":"true",bordered:!1,style:{width:"100%","max-width":"640px"}},{default:L(()=>[A($(ba),{value:c.value,"onUpdate:value":v[0]||(v[0]=h=>c.value=h),type:"line",animated:""},{default:L(()=>[A($(Te),{name:"General",tab:"General"},{tab:L(()=>[A($(be),{class:"text-lg",icon:"ri:file-user-line"}),f("span",qa,k(u.$t("setting.general")),1)]),default:L(()=>[f("div",Ja,[o.value?Zt("",!0):(G(),fe(Ea,{key:0,onUpdate:i}))])]),_:1}),A($(Te),{name:"Config",tab:"Config"},{tab:L(()=>[A($(be),{class:"text-lg",icon:"ri:list-settings-line"}),f("span",Za,k(u.$t("setting.config")),1)]),default:L(()=>[A(Ka)]),_:1})]),_:1},8,["value"])]),_:1})]),_:1},8,["show"]))}});export{tn as default};
