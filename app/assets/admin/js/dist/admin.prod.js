"use strict";!function(){var t=document.querySelector("#vvep-setting-wizard"),r=document.querySelector('#vvep-setting-wizard input[name="step"]'),e=document.querySelector("#vvep-reloadPostTypes"),n=document.querySelector("#clearExternalPostsCache");function a(e){alert(e.message)}function o(e,t){if((!(1<arguments.length&&void 0!==t)||t)&&(r.value=e.next_step,$stepContainer=document.querySelector("#step-"+e.next_step),$stepContainer?$stepContainer.classList.add("active"):alert(e.message)),e.input){var n=document.querySelector("#"+e.input);for(var a in n.innerHTML="",e.options){var o=document.createElement("option");o.value=a,o.text=e.options[a],n.appendChild(o)}}}function i(){document.querySelector(".vvep-wizard__wait").classList.toggle("active"),document.querySelector(".vvep-wizard__submit").classList.toggle("active")}t&&t.addEventListener("submit",function(e){e.preventDefault(),i(),fetch(vvepData.ajaxUrl,{method:"POST",credentials:"same-origin",body:new FormData(t)}).then(function(e){return e.json()}).then(function(e){var t=e.data;(t.is_valid?o:a)(t),i()}).catch(function(e){console.error(e)})}),e&&e.addEventListener("click",function(e){i(),fetch(vvepData.ajaxUrl,{method:"POST",credentials:"same-origin",body:new FormData(t)}).then(function(e){return e.json()}).then(function(e){var t=e.data;t.is_valid?o(t,!1):a(t),i()}).catch(function(e){console.error(e)})}),n&&n.addEventListener("click",function(e){n.disabled=!0,n.innerText="Limpando cache...";var t=new FormData;t.append("action","vvep_remove_cache"),fetch(vvepData.ajaxUrl,{method:"POST",credentials:"same-origin",body:t}).then(function(e){return e.json()}).then(function(e){alert("Cache apagado"),n.disabled=!1,n.innerText="Limpar cache dos posts"}).catch(function(e){console.error(e)})})}();