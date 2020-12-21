(function () {
  const $testConnection = document.querySelector("#vvep-testConnection");
  const $domainInput   = document.querySelector('#_vvep-domain');
  const $cleanCache = document.querySelector("#clearExternalPostsCache");

  if ($testConnection) {
      $testConnection.addEventListener("click", evt => {
      evt.preventDefault();

      $testConnection.innerText = 'Aguarde...';
      $testConnection.disabled  = true;
      const data = new FormData();
      data.append('action', 'vvep_setting_wizard');
      data.append('step', 'domain');
      data.append('domain', $domainInput.value); 

      fetch(vvepData.ajaxUrl, {
        method: "POST",
        credentials: "same-origin",
        body: data,
      })
      .then((res) => res.json())
      .then((res) => {
         const data = res.data;

         if(!data.is_valid) {
            alert(data.message);
            return;
         }

         const $target = document.querySelector("#" + data.input);
         $target.innerHTML = "";
         for (const val in data.options) {
            const opt = document.createElement("option");
            opt.value = val;
            opt.text = data.options[val];
            $target.appendChild(opt);
         }

         document.querySelectorAll('.after-domain').forEach(el => el.classList.remove('after-domain'));

         $testConnection.innerText = 'Testar Conexão';
         $testConnection.disabled  = false;
      })
      .catch((error) => {
         console.error(error);
      });
    });
  } 

  if ($cleanCache) {
    $cleanCache.addEventListener("click", (evt) => {
      $cleanCache.disabled = true;
      $cleanCache.innerText = "Limpando cache...";
      const data = new FormData();
      data.append("action", "vvep_remove_cache");

      fetch(vvepData.ajaxUrl, {
        method: "POST",
        credentials: "same-origin",
        body: data,
      })
        .then((res) => res.json())
        .then((res) => {
          alert("Cache apagado");
          $cleanCache.disabled = false;
          $cleanCache.innerText = "Limpar cache dos posts";
        })
        .catch((error) => {
          console.error(error);
        });
    });
  } 
})();
