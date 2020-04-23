class SlidingModal {
	_innerContent       = null;
	_modalContainer     = null;
	_contentWrapper     = null;
	_modalCloseButton   = null;
	_resizeable         = false;
	_modalPosition      = 'center';
	_cssClasses         = {
		'slideIn'           : 'fade-in-rotor',
		'slideOut'          : 'fade-out-rotor',
		'contentWrapper'    : 'pz-content-wrapper',
		'modalContainer'    : 'rotor pz-modal-wrapper fade-in-rotor',
		'modalContainerID'  : 'pz-modal-light-box',
	};
	_customEvents       = {
		'eventIn'           : 'ModalIsEntering',
		'eventOK'           : 'ModalHasEntered',
		'eventOut'          : 'ModalIsLeaving',
		'eventDone'         : 'ModalHasLeft',
	};
	
	constructor(content = null, closeBtnMarkUp=null) {
		this._innerContent      = content;
		this._modalCloseButton  = closeBtnMarkUp ? closeBtnMarkUp : this.makeCloseButton();
	}
	
	createRotor(content = null) {
		this._innerContent      = content ? content : this._innerContent;
		this._modalContainer    = document.createElement('div');
		this._contentWrapper    = document.createElement('div');
		this._modalContainer.id = this._cssClasses.modalContainerID;
		this._modalContainer.classList = this._cssClasses.modalContainer;
		this._contentWrapper.classList = this._cssClasses.contentWrapper;
		this._modalContainer.append(this._modalCloseButton);
		this._modalContainer.append(this._contentWrapper);
		document.body.append(this._modalContainer);
		
		this._modalContainer.addEventListener("animationend", (e)=>{
			console.log(e);
			if(e.animationName === 'fade-out'){
				this._modalContainer.parentNode.removeChild(this._modalContainer);
				this.dispatchCustomEvent(this._customEvents.eventDone, this._modalContainer,
					{dispatcher: this._modalContainer, value: '0', state: 'out'});
			}else if(e.animationName === 'fade-in'){
				this.dispatchCustomEvent(this._customEvents.eventOK, this._modalContainer,
					{dispatcher: this._modalContainer, value: '1', state: 'in'});
			}
		});
		
		this.mountInnerContent();
		return this._modalContainer;
	}
	
	injectRotor(e, content = null) {
		if (!this._modalContainer) {
			this._modalContainer = this.createRotor(content);
		}
		if (this._modalContainer.classList.contains(this._cssClasses.slideOut)) {
			this._modalContainer.classList.remove(this._cssClasses.slideOut);
		}
		this._modalContainer.classList.add(this._cssClasses.slideIn);
		
		this.dispatchCustomEvent(this._customEvents.eventIn, this._modalContainer, {dispatcher: this._modalContainer, value: '1', state: 'in'});
	}
	
	removeRotor() {
		if (this._modalContainer.classList.contains(this._cssClasses.slideIn)) {
			this._modalContainer.classList.remove(this._cssClasses.slideIn);
		}
		
		// this._modalContainer.addEventListener("animationend", ()=>{console.log('SLIDE-OUT Animation Done and Removed via Animation listener...');});
		this.dispatchCustomEvent(this._customEvents.eventOut, this._modalContainer, {dispatcher: this._modalContainer, value: '0', state: 'out'});
		this._modalContainer.classList.add(this._cssClasses.slideOut);
		/*
		const tOut = setTimeout(() => {
			this._modalContainer.parentNode.removeChild(this._modalContainer);
			this._modalContainer    = null;
			clearTimeout(tOut);
		}, 750);*/
	}
	
	mountInnerContent() {
		if(this._contentWrapper && this._innerContent) {
			this._contentWrapper.innerHTML      = this._innerContent;
			this._contentWrapper.style.opacity  = 0;
			this._contentWrapper.style.position = 'absolute';
			this._contentWrapper.style.opacity  = 1;
			this._contentWrapper.style.display  = 'block';
			this._contentWrapper.style.width    = '100%';
			this._contentWrapper.style.height   = '100%';
			this._contentWrapper.style.overflowY= 'auto';
			
			switch(this.modalPosition.toLowerCase()){
				case 'center':
					this._contentWrapper.style.top      = (window.innerHeight - this._contentWrapper.clientHeight)/2 + 'px';
					break;
				case 'top':
					this._contentWrapper.style.top      = '0px';
					break;
				case 'bottom':
					this._contentWrapper.style.bottom   = '0px';
					break;
			}
			if(this.resizeable){
				window.onresize = this.mountInnerContent.bind(this);
			}
		}
	}
	
	makeCloseButton(){
		this._modalCloseButton          = document.createElement('span');
		this._modalCloseButton.innerHTML= '&times;';
		
		this._modalCloseButton.style.display    = 'inline-block';
		this._modalCloseButton.style.position   = 'absolute';
		this._modalCloseButton.style.top        = '0';
		this._modalCloseButton.style.right      = '0';
		this._modalCloseButton.style.fontSize   = '60px';
		this._modalCloseButton.style.cursor     = 'pointer';
		this._modalCloseButton.style.lineHeight = 'default';
		this._modalCloseButton.style.marginTop  = '-10px';
		this._modalCloseButton.style.color      = 'white';
		this._modalCloseButton.style.zIndex     = 9999;
		
		this._modalCloseButton.addEventListener('click', this.removeRotor.bind(this));
		return this._modalCloseButton;
	}
	
	
	get innerContent() {
		return this._innerContent;
	}
	
	get modalContainer() {
		return this._modalContainer;
	}
	
	set modalContainer(value) {
		this._modalContainer = value;
	}
	
	set innerContent(value) {
		this._innerContent = value;
		this.mountInnerContent();
	}
	
	
	get resizeable() {
		return this._resizeable;
	}
	
	set resizeable(value) {
		this._resizeable = value;
	}
	
	get modalPosition() {
		return this._modalPosition;
	}
	
	set modalPosition(value) {
		this._modalPosition = value;
	}
	
	dispatchCustomEvent(eventName, domElement, payload = null) {
		// var event = new Event('build');
		const event = new CustomEvent(eventName, {detail: payload});
		domElement.dispatchEvent(event);
		
		window.console.log(eventName + ' was dispatched with payload: ...');
		window.console.log(payload);
	}
}