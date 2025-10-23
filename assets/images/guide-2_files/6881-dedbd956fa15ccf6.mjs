"use strict";(self.modernJsonp=self.modernJsonp||[]).push([[6881,61257],{25690:(e,t,n)=>{n.d(t,{default:()=>a});var i=n(718222);let r=`pulsing {
  0% {
    opacity: 1;
  }

  50% {
    opacity: 0.4;
  }

  100% {
    opacity: 1;
  }
}`,a={css:(0,i.Ll)([r]),animation:"pulsing 2s infinite"}},633569:(e,t,n)=>{n.r(t),n.d(t,{default:()=>W});var i=n(667294),r=n(20256),a=n(569681),o=n(19963),l=n(756064);function s(e,t,n){var i;return(t="symbol"==typeof(i=function(e,t){if("object"!=typeof e||!e)return e;var n=e[Symbol.toPrimitive];if(void 0!==n){var i=n.call(e,t||"default");if("object"!=typeof i)return i;throw TypeError("@@toPrimitive must return a primitive value.")}return("string"===t?String:Number)(e)}(t,"string"))?i:i+"")in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}let u={},m=e=>{let t=e.__id||e.id;return"string"==typeof t&&t||null};class p{constructor(){s(this,"idMap",new Map),s(this,"objMap",new WeakMap)}get(e){let t=m(e);return this.objMap.get(e)??(t?this.idMap.get(t):void 0)}has(e){let t=m(e);return this.objMap.has(e)??(!!t&&this.idMap.has(t))}set(e,t){let n=m(e);n&&this.idMap.set(n,t),this.objMap.set(e,t)}reset(){this.idMap=new Map,this.objMap=new WeakMap}}function d(e,t){return"number"==typeof e?e:"lg1"===t?e[t]??e.lg??1:e[t]??1}var c=n(399083),h=n(824834),f=n(25690),y=n(247854),g=n(970601),x=n(785893);let{css:b,animation:w}=f.default,v={backgroundColor:y.zsO,animation:w,borderRadius:y.saV};function C({data:e}){let{height:t}=e;return(0,x.jsxs)(i.Fragment,{children:[(0,x.jsx)(g.Z,{unsafeCSS:b}),(0,x.jsx)(r.xu,{dangerouslySetInlineStyle:{__style:v},"data-test-id":"skeleton-pin",children:(0,x.jsx)(r.xu,{height:t})})]})}var S=n(56063),_=n(967312),M=n(174646),R=n(538645),$=n(992114),k=n(349167),j=n(438596);function W(e){let{align:t,cacheKey:n,id:s,isFetching:m,isGridCentered:f=!0,items:y,layout:b,loadItems:w,masonryRef:v,optOutFluidGridExperiment:W=!1,renderItem:G,scrollContainerRef:I,virtualize:E=!0,getColumnSpanConfig:T,_getResponsiveModuleConfigForSecondItem:z,isLoadingStateEnabled:A,initialLoadingStatePinCount:P,isLoadingAccessibilityLabel:F,isLoadedAccessibilityLabel:O}=e,L=(0,R.ZP)(),Z=(0,M.B)(),{isAuthenticated:H,isRTL:X}=Z,{logContextEvent:D}=(0,o.u)(),B=(0,_.r)(),N="desktop"===L,Q=(0,j.Zv)(),{group:J}=(0,k.DB)(),V=((0,i.useRef)(y.map(()=>({fetchTimestamp:Date.now(),measureTimestamp:Date.now(),hasRendered:!1,pageCount:0}))),N&&!W),{experimentalColumnWidth:Y,experimentalGutter:q}=(0,c.Z)(V),K=e.serverRender??!!N,U="flexible"===b||"uniformRowFlexible"===b||"desktop"!==L||V,ee=(U&&b?.startsWith("uniformRow")?"uniformRowFlexible":void 0)??(K?"serverRenderedFlexible":"flexible"),et=e.columnWidth??Y??S.yF;U&&(et=Math.floor(et));let en=e.gutterWidth??q??(N?S.oX:1),ei=e.minCols??S.yc,er=(0,i.useRef)(0),ea=et+en,eo=function(e){if(null==e)return;let t=function(e){let t=u[e];return t&&t.screenWidth===window.innerWidth||(u[e]={screenWidth:window.innerWidth}),u[e]}(e);return t.measurementCache||(t.measurementCache=new p),t.measurementCache}(n),el=(0,i.useCallback)(()=>I?.current||window,[I]),es=(0,i.useRef)(!0),{anyEnabled:eu}=B.checkExperiment("web_masonry_pin_overlap_calculation_and_logging"),{anyEnabled:em}=B.checkExperiment("web_masonry_fluid_reflow"),{anyEnabled:ep}=B.checkExperiment("visual_search_stl_eligibility_check_migration_gss_css",{dangerouslySkipActivation:!0}),ed=f&&es.current?"centered":"",{className:ec,styles:eh}=function(e){let t=`m_${Object.keys(e).sort().reduce((t,n)=>{let i=e[n];return null==i||"object"==typeof i||"function"==typeof i?t:"boolean"==typeof i?t+(i?"t":"f"):t+i},"").replace(/\:/g,"\\:")}`,{flexible:n,gutterWidth:i,isRTL:r,itemWidth:a,maxColumns:o,minColumns:l,items:s,getColumnSpanConfig:u,_getResponsiveModuleConfigForSecondItem:m}=e,p=u?s.map((e,t)=>({index:t,columnSpanConfig:u(e)??1})).filter(e=>1!==e.columnSpanConfig):[],c=a+i,h=Array.from({length:o+1-l},(e,t)=>t+l).map(e=>{let h,f,y=e===l?0:e*c,g=e===o?null:(e+1)*c-.01;u&&m&&s.length>1&&(h=u(s[0]),f=m(s[1]));let{styles:x,numberOfVisibleItems:b}=p.reduce((r,o)=>{let{columnSpanConfig:l}=o,u=Math.min(function({columnCount:e,columnSpanConfig:t,firstItemColumnSpanConfig:n,isFlexibleWidthItem:i,secondItemResponsiveModuleConfig:r}){let a=e<=2?"sm":e<=4?"md":e<=6?"lg1":e<=8?"lg":"xl",o=d(t,a);if(i){let t=d(n,a);o="number"==typeof r?r:r?Math.max(r.min,Math.min(r.max,e-t)):1}return o}({columnCount:e,columnSpanConfig:l,isFlexibleWidthItem:!!f&&o===s[1],firstItemColumnSpanConfig:h??1,secondItemResponsiveModuleConfig:f??1}),e),m=null!=o.index&&r.numberOfVisibleItems>=u+o.index,p=n?100/e*u:a*u+i*(u-1),{numberOfVisibleItems:c}=r;return m?c-=u-1:o.index<c&&(c+=1),{styles:r.styles.concat(function({className:e,index:t,columnSpanConfig:n,visible:i,width:r,flexible:a}){let o="number"==typeof n?n:btoa(JSON.stringify(n));return a?`
      .${e} .static[data-column-span="${o}"]:nth-child(${t+1}) {
        visibility: ${i?"visible":"hidden"} !important;
        position: ${i?"inherit":"absolute"} !important;
        width: ${r}% !important;
      }`:`
      .${e} .static[data-column-span="${o}"]:nth-child(${t+1}) {
        visibility: ${i?"visible":"hidden"} !important;
        position: ${i?"inherit":"absolute"} !important;
        width: ${r}px !important;
      }`}({className:t,index:o.index,columnSpanConfig:l,visible:m,width:p,flexible:n})),numberOfVisibleItems:c}},{styles:"",numberOfVisibleItems:e}),w=n?`
      .${t} .static {
        box-sizing: border-box;
        width: calc(100% / ${e}) !important;
      }
    `:`
      .${t} {
        max-width: ${e*c}px;
      }

      .${t} .static {
        width: ${a}px !important;
      }
    `;return{minWidth:y,maxWidth:g,styles:`
      .${t} .static:nth-child(-n+${b}) {
        position: static !important;
        visibility: visible !important;
        float: ${r?"right":"left"};
        display: block;
      }

      .${t} .static {
        padding: 0 ${i/2}px;
      }

      ${w}

      ${x}
    `}}),f=h.map(({minWidth:e,maxWidth:t,styles:n})=>`
    @container (min-width: ${e}px) ${t?`and (max-width: ${t}px)`:""} {
      ${n}
    }
  `),y=h.map(({minWidth:e,maxWidth:t,styles:n})=>`
    @media (min-width: ${e}px) ${t?`and (max-width: ${t}px)`:""} {
      ${n}
    }
  `),g=`
    ${f.join("")}
    @supports not (container-type: inline-size) {
      ${y.join("")}
    }
  `;return{className:t,styles:`
    .masonryContainer:has(.${t}) {
      container-type: inline-size;
    }

    .masonryContainer > .centered {
      margin-left: auto;
      margin-right: auto;
    }

    .${t} .static {
      position: absolute !important;
      visibility: hidden !important;
    }

    ${g}
  `}}({gutterWidth:en,flexible:U,items:y,isRTL:X,itemWidth:et,maxColumns:e.maxColumns??Math.max(y.length,S.g5),minColumns:ei,getColumnSpanConfig:T,_getResponsiveModuleConfigForSecondItem:z}),ef=`${ed} ${ec}`.trim(),{anyEnabled:ey,expName:eg,group:ex,isMeasureAllEnabled:eb}=(0,h.Z)(),ew=((0,i.useRef)(void 0),(0,i.useRef)(y.length)),ev=(0,i.useRef)(0),eC=(0,i.useRef)(null);(0,i.useEffect)(()=>{ew.current=y.length,ev.current+=1},[y]),(0,i.useEffect)(()=>{if(es.current&&(es.current=!1),window.earlyGridRenderStats){let e={...(0,k.M3)({earlyHydrationGroup:J,handlerId:Q,requestContext:Z}),status:window.earlyGridRenderStats.status??"unknown"};(0,$.nP)(`earlyHydrationDebug.masonry.earlyGridRender.status.${window.earlyGridRenderStats.status}`,{tags:e}),(0,$.LY)("earlyHydrationDebug.masonry.earlyGridRender.init",window.earlyGridRenderStats.init,{tags:e}),window.earlyGridRenderStats.start&&(0,$.LY)("earlyHydrationDebug.masonry.earlyGridRender.start",window.earlyGridRenderStats.start,{tags:e}),window.earlyGridRenderStats.end&&(0,$.LY)("earlyHydrationDebug.masonry.earlyGridRender.end",window.earlyGridRenderStats.end,{tags:e})}},[]),(0,i.useEffect)(()=>()=>{},[]);let eS=(0,i.useCallback)(e=>{let t=e.reduce((e,t)=>e+t),n=t/e.length;(0,$.S0)("webapp.masonry.multiColumnWhitespace.average",n,{sampleRate:1,tags:{experimentalMasonryGroup:ex||"unknown",handlerId:Q,isAuthenticated:H,multiColumnItemSpan:e.length}}),(0,$.S0)("webapp.masonry.twoColWhitespace",n,{sampleRate:1,tags:{columnWidth:et,minCols:ei}}),D({event_type:15878,component:14468,aux_data:{total_whitespace_px:t}}),D({event_type:16062,component:14468,aux_data:{average_whitespace_px:n}}),D({event_type:16063,component:14468,aux_data:{max_whitespace_px:Math.max(...e)}}),e.forEach(t=>{t>=50&&((0,$.nP)("webapp.masonry.multiColumnWhitespace.over50",{sampleRate:1,tags:{experimentalMasonryGroup:ex||"unknown",handlerId:Q,isAuthenticated:H,multiColumnItemSpan:e.length}}),D({event_type:16261,component:14468})),t>=100&&((0,$.nP)("webapp.masonry.multiColumnWhitespace.over100",{sampleRate:1,tags:{experimentalMasonryGroup:ex||"unknown",handlerId:Q,isAuthenticated:H,multiColumnItemSpan:e.length}}),D({event_type:16262,component:14468}))}),(0,$.nP)("webapp.masonry.multiColumnWhitespace.count",{sampleRate:1,tags:{experimentalMasonryGroup:ex||"unknown",handlerId:Q,isAuthenticated:H,multiColumnItemSpan:e.length}})},[et,D,ei,H,Q,ex]),{_items:e_,_renderItem:eM}=function({initialLoadingStatePinCount:e=50,infiniteScrollPinCount:t=10,isFetching:n,items:r=[],renderItem:a,isLoadingStateEnabled:o}){let l=+(r.filter(e=>"object"==typeof e&&null!==e&&"type"in e&&"closeup_module"===e.type).length>0),s=o&&n,u=(0,i.useMemo)(()=>Array.from({length:r.length>l?t:e}).reduce((e,t,n)=>[...e,{height:n%2==0?356:236,key:`skeleton-pin-${n}`,isSkeleton:!0}],[]),[r.length,l,t,e]);return{_items:(0,i.useMemo)(()=>s?[...r,...u]:r,[s,r,u]),_renderItem:(0,i.useMemo)(()=>o?e=>{let{itemIdx:t,data:n}=e;return t>=r.length&&n&&"object"==typeof n&&"key"in n&&"height"in n?(0,x.jsx)(C,{data:n},n.key):a(e)}:a,[o,a,r.length])}}({isLoadingStateEnabled:A,items:y,renderItem:(0,i.useCallback)(e=>(0,x.jsx)(l.Z,{name:"MasonryItem",children:G(e)}),[G]),isFetching:m,initialLoadingStatePinCount:P}),eR=A&&m,e$=(0,i.useRef)(new Set);(0,i.useEffect)(()=>{if(!eu)return;let e=setTimeout(()=>{requestAnimationFrame(()=>{let e=Array.from(eC.current?.querySelectorAll("[data-grid-item-idx]")??[]);if(0===e.length)return;let t=e.map(e=>{let t=e.getAttribute("data-grid-item-idx");return{rect:e.getBoundingClientRect(),itemIdx:t}}),n=0,i=0,r=0,a=0,o=0,l=0;for(let e=0;e<t.length;e+=1){let s=t[e]?.rect,u=t[e]?.itemIdx;for(let m=e+1;m<t.length;m+=1){let e=t[m]?.rect,p=t[m]?.itemIdx;if(s&&e&&u&&p){let t=[u,p].sort().join("|");if(!e$.current.has(t)&&s.right>=e.left&&s.left<=e.right&&s.bottom>=e.top&&s.top<=e.bottom&&s.height>0&&e.height>0){e$.current.add(t),n+=1;let u=Math.max(0,Math.min(s.right,e.right)-Math.max(s.left,e.left))*Math.max(0,Math.min(s.bottom,e.bottom)-Math.max(s.top,e.top));u>8e4?l+=1:u>4e4?o+=1:u>1e4?a+=1:u>5e3?r+=1:u>2500&&(i+=1)}}}}n>0&&(0,$.QX)("webapp.masonry.pinOverlapHits",n,{tags:{isAuthenticated:H,isDesktop:N,handlerId:Q,experimentalMasonryGroup:ex||"unknown",fluidResizeExperiment:em?"true":"false",visualSearchSTLexperiment:ep?"true":"false"}}),i>0&&(0,$.QX)("webapp.masonry.pinOverlap.AreaPx.over2500",i,{tags:{isAuthenticated:H,isDesktop:N,handlerId:Q,experimentalMasonryGroup:ex||"unknown",fluidResizeExperiment:em?"true":"false",visualSearchSTLexperiment:ep?"true":"false"}}),r>0&&(0,$.QX)("webapp.masonry.pinOverlap.AreaPx.over5000",r,{tags:{isAuthenticated:H,isDesktop:N,handlerId:Q,experimentalMasonryGroup:ex||"unknown",fluidResizeExperiment:em?"true":"false",visualSearchSTLexperiment:ep?"true":"false"}}),a>0&&(0,$.QX)("webapp.masonry.pinOverlap.AreaPx.over10000",a,{tags:{isAuthenticated:H,isDesktop:N,handlerId:Q,experimentalMasonryGroup:ex||"unknown",fluidResizeExperiment:em?"true":"false",visualSearchSTLexperiment:ep?"true":"false"}}),o>0&&(0,$.QX)("webapp.masonry.pinOverlap.AreaPx.over40000",o,{tags:{isAuthenticated:H,isDesktop:N,handlerId:Q,experimentalMasonryGroup:ex||"unknown",fluidResizeExperiment:em?"true":"false",visualSearchSTLexperiment:ep?"true":"false"}}),l>0&&(0,$.QX)("webapp.masonry.pinOverlap.AreaPx.over80000",l,{tags:{isAuthenticated:H,isDesktop:N,handlerId:Q,experimentalMasonryGroup:ex||"unknown",fluidResizeExperiment:em?"true":"false",visualSearchSTLexperiment:ep?"true":"false"}})})},1e3);return()=>{clearTimeout(e)}},[et,ex,em,H,N,eu,y,Q,ep]);let ek=(0,a.Z)(),ej=(0,i.useCallback)(e=>{v&&(v.current=e)},[v]);return(0,x.jsxs)(i.Fragment,{children:[A&&!es.current&&(0,x.jsx)(r.xu,{"aria-live":"polite",display:"visuallyHidden",children:eR?F:O}),(0,x.jsx)("div",{ref:eC,"aria-busy":A?!!eR:void 0,className:"masonryContainer","data-test-id":"masonry-container",id:s,style:V?{padding:`0 ${en/2}px`}:void 0,children:(0,x.jsxs)("div",{className:ef,children:[K&&es.current?(0,x.jsx)(g.Z,{"data-test-id":"masonry-ssr-styles",unsafeCSS:eh}):null,(0,x.jsx)(r.xu,{"data-test-id":"max-width-container",marginBottom:0,marginEnd:"auto",marginStart:"auto",marginTop:0,maxWidth:e.maxColumns?ea*e.maxColumns:void 0,children:ey?(0,x.jsx)(r.GX,{ref:ek?ej:e=>{v&&(v.current=e)},_dynamicHeights:!0,_getResponsiveModuleConfigForSecondItem:z,_logTwoColWhitespace:eS,_measureAll:eb,align:t,columnWidth:et,getColumnSpanConfig:T,gutterWidth:en,items:e_,layout:U?ee:b??"basic",loadItems:w,measurementStore:eo,minCols:ei,renderItem:eM,scrollContainer:el,virtualBufferFactor:.3,virtualize:E}):(0,x.jsx)(r.Rk,{ref:ek?ej:e=>{v&&(v.current=e)},_dynamicHeights:!0,_fluidResize:em,_getResponsiveModuleConfigForSecondItem:z,_logTwoColWhitespace:eS,align:t,columnWidth:et,getColumnSpanConfig:T,gutterWidth:en,items:e_,layout:U?ee:b??"basic",loadItems:w,measurementStore:eo,minCols:ei,renderItem:eM,scrollContainer:el,virtualBufferFactor:.3,virtualize:E})})]})})]})}},399083:(e,t,n)=>{n.d(t,{Z:()=>i});function i(e=!0){let t=e?16:void 0,n=t?Math.floor(t/4):void 0;return{experimentalColumnWidth:e?221:void 0,experimentalGutter:t,experimentalGutterBoints:n}}}}]);
//# sourceMappingURL=https://sm.pinimg.com/webapp/6881-dedbd956fa15ccf6.mjs.map