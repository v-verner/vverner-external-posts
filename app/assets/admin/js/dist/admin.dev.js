"use strict";

(function () {
  var $testConnection = document.querySelector("#vvep-testConnection");
  var $domainInput = document.querySelector('#_vvep-domain');
  var $cleanCache = document.querySelector("#clearExternalPostsCache");

  if ($testConnection) {
    $testConnection.addEventListener("click", function (evt) {
      evt.preventDefault();
      $testConnection.innerText = 'Aguarde...';
      $testConnection.disabled = true;
      var data = new FormData();
      data.append('action', 'vvep_setting_wizard');
      data.append('step', 'domain');
      data.append('domain', $domainInput.value);
      fetch(vvepData.ajaxUrl, {
        method: "POST",
        credentials: "same-origin",
        body: data
      }).then(function (res) {
        return res.json();
      }).then(function (res) {
        var data = res.data;

        if (!data.is_valid) {
          alert(data.message);
          return;
        }

        var $target = document.querySelector("#" + data.input);
        $target.innerHTML = "";

        for (var val in data.options) {
          var opt = document.createElement("option");
          opt.value = val;
          opt.text = data.options[val];
          $target.appendChild(opt);
        }

        document.querySelectorAll('.after-domain').forEach(function (el) {
          return el.classList.remove('after-domain');
        });
        $testConnection.innerText = 'Testar Conexão';
        $testConnection.disabled = false;
      })["catch"](function (error) {
        console.error(error);
      });
    });
  }

  if ($cleanCache) {
    $cleanCache.addEventListener("click", function (evt) {
      $cleanCache.disabled = true;
      $cleanCache.innerText = "Limpando cache...";
      var data = new FormData();
      data.append("action", "vvep_remove_cache");
      fetch(vvepData.ajaxUrl, {
        method: "POST",
        credentials: "same-origin",
        body: data
      }).then(function (res) {
        return res.json();
      }).then(function (res) {
        alert("Cache apagado");
        $cleanCache.disabled = false;
        $cleanCache.innerText = "Limpar cache dos posts";
      })["catch"](function (error) {
        console.error(error);
      });
    });
  }
})();