var SlidingModal = /** @class */ (function () {
    function SlidingModal(content, closeBtnMarkUp) {
        if (content === void 0) { content = null; }
        if (closeBtnMarkUp === void 0) { closeBtnMarkUp = null; }
        this._innerContent = null;
        this._modalContainer = null;
        this._contentWrapper = null;
        this._modalCloseButton = null;
        this._resizeable = false;
        this._modalPosition = 'center';
        this._cssClasses = {
            'slideIn': 'fade-in-rotor',
            'slideOut': 'fade-out-rotor',
            'contentWrapper': 'pz-content-wrapper',
            'modalContainer': 'rotor pz-modal-wrapper fade-in-rotor',
            'modalContainerID': 'pz-modal-light-box'
        };
        this._customEvents = {
            'eventIn': 'ModalIsEntering',
            'eventOK': 'ModalHasEntered',
            'eventOut': 'ModalIsLeaving',
            'eventDone': 'ModalHasLeft'
        };
        this._innerContent = content;
        this._modalCloseButton = closeBtnMarkUp ? closeBtnMarkUp : this.makeCloseButton();
    }
    SlidingModal.prototype.createRotor = function (content) {
        var _this = this;
        if (content === void 0) { content = null; }
        this._innerContent = content ? content : this._innerContent;
        this._modalContainer = document.createElement('div');
        this._contentWrapper = document.createElement('div');
        this._modalContainer.id = this._cssClasses.modalContainerID;
        this._modalContainer.classList = this._cssClasses.modalContainer;
        this._contentWrapper.classList = this._cssClasses.contentWrapper;
        this._modalContainer.append(this._modalCloseButton);
        this._modalContainer.append(this._contentWrapper);
        document.body.append(this._modalContainer);
        this._modalContainer.addEventListener("animationend", function (e) {
            console.log(e);
            if (e.animationName === 'fade-out') {
                _this._modalContainer.parentNode.removeChild(_this._modalContainer);
                _this.dispatchCustomEvent(_this._customEvents.eventDone, _this._modalContainer, { dispatcher: _this._modalContainer, value: '0', state: 'out' });
            }
            else if (e.animationName === 'fade-in') {
                _this.dispatchCustomEvent(_this._customEvents.eventOK, _this._modalContainer, { dispatcher: _this._modalContainer, value: '1', state: 'in' });
            }
        });
        this.mountInnerContent();
        return this._modalContainer;
    };
    SlidingModal.prototype.injectRotor = function (e, content) {
        if (content === void 0) { content = null; }
        if (!this._modalContainer) {
            this._modalContainer = this.createRotor(content);
        }
        if (this._modalContainer.classList.contains(this._cssClasses.slideOut)) {
            this._modalContainer.classList.remove(this._cssClasses.slideOut);
        }
        this._modalContainer.classList.add(this._cssClasses.slideIn);
        this.dispatchCustomEvent(this._customEvents.eventIn, this._modalContainer, { dispatcher: this._modalContainer, value: '1', state: 'in' });
    };
    SlidingModal.prototype.removeRotor = function () {
        if (this._modalContainer.classList.contains(this._cssClasses.slideIn)) {
            this._modalContainer.classList.remove(this._cssClasses.slideIn);
        }
        // this._modalContainer.addEventListener("animationend", ()=>{console.log('SLIDE-OUT Animation Done and Removed via Animation listener...');});
        this.dispatchCustomEvent(this._customEvents.eventOut, this._modalContainer, { dispatcher: this._modalContainer, value: '0', state: 'out' });
        this._modalContainer.classList.add(this._cssClasses.slideOut);
        /*
        const tOut = setTimeout(() => {
            this._modalContainer.parentNode.removeChild(this._modalContainer);
            this._modalContainer    = null;
            clearTimeout(tOut);
        }, 750);*/
    };
    SlidingModal.prototype.mountInnerContent = function () {
        if (this._contentWrapper && this._innerContent) {
            this._contentWrapper.innerHTML = this._innerContent;
            this._contentWrapper.style.opacity = 0;
            this._contentWrapper.style.position = 'absolute';
            this._contentWrapper.style.opacity = 1;
            this._contentWrapper.style.display = 'block';
            this._contentWrapper.style.width = '100%';
            this._contentWrapper.style.height = '100%';
            this._contentWrapper.style.overflowY = 'auto';
            switch (this.modalPosition.toLowerCase()) {
                case 'center':
                    this._contentWrapper.style.top = (window.innerHeight - this._contentWrapper.clientHeight) / 2 + 'px';
                    break;
                case 'top':
                    this._contentWrapper.style.top = '0px';
                    break;
                case 'bottom':
                    this._contentWrapper.style.bottom = '0px';
                    break;
            }
            if (this.resizeable) {
                window.onresize = this.mountInnerContent.bind(this);
            }
        }
    };
    SlidingModal.prototype.makeCloseButton = function () {
        this._modalCloseButton = document.createElement('span');
        this._modalCloseButton.innerHTML = '&times;';
        this._modalCloseButton.style.display = 'inline-block';
        this._modalCloseButton.style.position = 'absolute';
        this._modalCloseButton.style.top = '0';
        this._modalCloseButton.style.right = '0';
        this._modalCloseButton.style.fontSize = '60px';
        this._modalCloseButton.style.cursor = 'pointer';
        this._modalCloseButton.style.lineHeight = 'default';
        this._modalCloseButton.style.marginTop = '-10px';
        this._modalCloseButton.style.color = 'white';
        this._modalCloseButton.style.zIndex = 9999;
        this._modalCloseButton.addEventListener('click', this.removeRotor.bind(this));
        return this._modalCloseButton;
    };
    Object.defineProperty(SlidingModal.prototype, "innerContent", {
        get: function () {
            return this._innerContent;
        },
        set: function (value) {
            this._innerContent = value;
            this.mountInnerContent();
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(SlidingModal.prototype, "modalContainer", {
        get: function () {
            return this._modalContainer;
        },
        set: function (value) {
            this._modalContainer = value;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(SlidingModal.prototype, "resizeable", {
        get: function () {
            return this._resizeable;
        },
        set: function (value) {
            this._resizeable = value;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(SlidingModal.prototype, "modalPosition", {
        get: function () {
            return this._modalPosition;
        },
        set: function (value) {
            this._modalPosition = value;
        },
        enumerable: true,
        configurable: true
    });
    SlidingModal.prototype.dispatchCustomEvent = function (eventName, domElement, payload) {
        if (payload === void 0) { payload = null; }
        // var event = new Event('build');
        var event = new CustomEvent(eventName, { detail: payload });
        domElement.dispatchEvent(event);
        window.console.log(eventName + ' was dispatched with payload: ...');
        window.console.log(payload);
    };
    return SlidingModal;
}());
