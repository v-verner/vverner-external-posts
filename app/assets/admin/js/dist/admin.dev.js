"use strict";

(function () {
  var $wizard = document.querySelector('#vvep-setting-wizard');
  var $stepInput = document.querySelector('#vvep-setting-wizard input[name="step"]');
  var $reloadPostTypes = document.querySelector('#vvep-reloadPostTypes');
  var $cleanCache = document.querySelector('#clearExternalPostsCache');

  if ($wizard) {
    $wizard.addEventListener('submit', function (evt) {
      evt.preventDefault();
      toggleLoaderStatus();
      fetch(vvepData.ajaxUrl, {
        method: 'POST',
        credentials: 'same-origin',
        body: new FormData($wizard)
      }).then(function (res) {
        return res.json();
      }).then(function (res) {
        var data = res.data;
        data.is_valid ? handlerStepSuccess(data) : handlerStepError(data);
        toggleLoaderStatus();
      })["catch"](function (error) {
        console.error(error);
      });
    });
  }

  if ($reloadPostTypes) {
    $reloadPostTypes.addEventListener('click', function (evt) {
      toggleLoaderStatus();
      fetch(vvepData.ajaxUrl, {
        method: 'POST',
        credentials: 'same-origin',
        body: new FormData($wizard)
      }).then(function (res) {
        return res.json();
      }).then(function (res) {
        var data = res.data;
        data.is_valid ? handlerStepSuccess(data, false) : handlerStepError(data);
        toggleLoaderStatus();
      })["catch"](function (error) {
        console.error(error);
      });
    });
  }

  if ($cleanCache) {
    $cleanCache.addEventListener('click', function (evt) {
      $cleanCache.disabled = true;
      $cleanCache.innerText = 'Limpando cache...';
      var data = new FormData();
      data.append('action', 'vvep_remove_cache');
      fetch(vvepData.ajaxUrl, {
        method: 'POST',
        credentials: 'same-origin',
        body: data
      }).then(function (res) {
        return res.json();
      }).then(function (res) {
        alert('Cache apagado');
        $cleanCache.disabled = false;
        $cleanCache.innerText = 'Limpar cache dos posts';
      })["catch"](function (error) {
        console.error(error);
      });
    });
  }

  function handlerStepError(data) {
    alert(data.message);
  }

  function handlerStepSuccess(data) {
    var updateStep = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

    if (updateStep) {
      $stepInput.value = data.next_step;
      $stepContainer = document.querySelector('#step-' + data.next_step);

      if ($stepContainer) {
        $stepContainer.classList.add('active');
      } else {
        alert(data.message);
      }
    }

    if (data.input) {
      var $target = document.querySelector('#' + data.input);
      $target.innerHTML = '';

      for (var val in data.options) {
        var opt = document.createElement('option');
        opt.value = val;
        opt.text = data.options[val];
        $target.appendChild(opt);
      }
    }
  }

  function toggleLoaderStatus() {
    var $loader = document.querySelector('.vvep-wizard__wait');
    $loader.classList.toggle('active');
    var $submit = document.querySelector('.vvep-wizard__submit');
    $submit.classList.toggle('active');
  }
})();