;(function($){
    $(document).ready(function(){  
        $(".ewf-iframe").each(function(){
           var form_id =  $(this).data("form");
           var title =  $(this).data("title");
           console.log(form_id);
            var ewfFormWizard = new EWFFormWizard(form_id,title);
            ewfFormWizard.wizardIFrame();
            ewfFormWizard.wizardPlaceholder();
            ewfFormWizard.receiveIFrameMessage();
        });
    });
}(jQuery));



function EWFFormWizard(formId, formTitle) {
    const iframeId = `easywebsiteform-${formId}`;
    const iframeContainerId = `iframe-${formId}`;
    const iframeLoaderId = `iframe-loader-${formId}`;
    const iframeOverlayId = `iframe-overlay-${formId}`;

    this.wizardIFrame = function () {
        const iframe = document.createElement('iframe');
        iframe.name = 'easywebsiteform';
        iframe.setAttribute('data-formid', formId);
        iframe.id = iframeId;
        iframe.title = formTitle;
        iframe.className = 'easywebsiteform_iframe';
        iframe.src = `https://www.easywebsiteform.com/form/${formId}`;
        iframe.allowtransparency = 'true';
        iframe.allowfullscreen = true;
        iframe.style.width = '100%';
        iframe.style.maxWidth = '100%';
        iframe.style.border = 'none';
        iframe.scrolling = 'no';
        iframe.onload = function () {
            window.parent.scrollTo(0, 0);
        };

        const iframeContainer = document.getElementById(iframeContainerId);
        if (iframeContainer){
            iframeContainer.appendChild(iframe);
        }
    }

    this.wizardPlaceholder = function () {
        const iframeElement = document.getElementById(iframeId);

        if (iframeElement) {
            iframeElement.addEventListener('load', function () {
                const iframeLoader = document.getElementById(iframeLoaderId);
                const iframeOverlay = document.getElementById(iframeOverlayId);

                if (iframeLoader) {
                    iframeLoader.style.display = 'none';
                }

                if (iframeOverlay) {
                    iframeOverlay.style.display = 'none';
                }
            });
        }
    }
    this.receiveIFrameMessage = function () {
        function handleIFrameMessage(e) {
            if (!e.data || !e.data.ewf) return;
            const ewf = e.data.ewf;
            const iframeElement = document.getElementById(`easywebsiteform-${ewf.uid || ""}`);
            if (iframeElement) {
                iframeElement.style.height = (ewf.height || "") + "px";
            }
        }
        window.addEventListener("message", handleIFrameMessage);
    }
}
