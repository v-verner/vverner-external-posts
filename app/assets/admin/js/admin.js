(function () {
    const $wizard           = document.querySelector('#vvep-setting-wizard');
    const $stepInput        = document.querySelector('#vvep-setting-wizard input[name="step"]');
    const $reloadPostTypes  = document.querySelector('#vvep-reloadPostTypes');
    const $cleanCache       = document.querySelector('#clearExternalPostsCache');

    if ($wizard) {
        $wizard.addEventListener('submit', evt => {
            evt.preventDefault();

            toggleLoaderStatus();

            fetch(vvepData.ajaxUrl, {
                method: 'POST',
                credentials: 'same-origin',
                body: new FormData($wizard)
            })
            .then(res => res.json())
            .then(res => {
                const data = res.data;
                data.is_valid ? handlerStepSuccess(data) : handlerStepError(data);
                toggleLoaderStatus();
            })
            .catch((error) => {
                console.error(error);
            });
        })
    }

    if($reloadPostTypes) {
        $reloadPostTypes.addEventListener('click', evt => {
            toggleLoaderStatus();

            fetch(vvepData.ajaxUrl, {
                method: 'POST',
                credentials: 'same-origin',
                body: new FormData($wizard)
            })
            .then(res => res.json())
            .then(res => {
                const data = res.data;
                data.is_valid ? handlerStepSuccess(data, false) : handlerStepError(data);
                toggleLoaderStatus();
            })
            .catch((error) => {
                console.error(error);
            });

        })
    }

    if($cleanCache) {
        $cleanCache.addEventListener('click', evt => {
            $cleanCache.disabled = true;
            $cleanCache.innerText = 'Limpando cache...';
            const data = new FormData();
            data.append( 'action', 'vvep_remove_cache' );

            fetch(vvepData.ajaxUrl, {
                method: 'POST',
                credentials: 'same-origin',
                body: data
            })
            .then(res => res.json())
            .then(res => {
                alert('Cache apagado');
                $cleanCache.disabled  = false;
                $cleanCache.innerText = 'Limpar cache dos posts';

            })
            .catch((error) => {
                console.error(error);
            });


        })

    }

    function handlerStepError(data) {
        alert(data.message);
    } 

    function handlerStepSuccess(data, updateStep = true) {
        if(updateStep) {
            $stepInput.value = data.next_step;
            $stepContainer = document.querySelector('#step-' + data.next_step);

            if($stepContainer) {
                $stepContainer.classList.add('active');
            } else {
                alert(data.message);
            }
        }

        if(data.input) {
            const $target = document.querySelector('#' + data.input);
            $target.innerHTML = '';

            for(const val in data.options) {
                const opt = document.createElement('option');
                opt.value = val;
                opt.text  = data.options[val];
                $target.appendChild(opt);
            }

        }
    }

    function toggleLoaderStatus() {
        const $loader = document.querySelector('.vvep-wizard__wait');
        $loader.classList.toggle('active')

        const $submit = document.querySelector('.vvep-wizard__submit');
        $submit.classList.toggle('active')
    }
}());