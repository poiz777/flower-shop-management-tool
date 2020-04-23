(function($){
    $(document).ready(function(e){
        let viewRawPassToggle       = $('#pz-view-raw-pass-toggle.pz-view-raw-pass-toggle');
        let cashRegSendBtn          = $('#pz-cash-reg-form-submit');
        let cloneCountTriggers      = $('#pzSetCloneButton, #pzSetCloneCount');
        let yearChooser             = $('#year.form-control.pz-form-widget');   //$('input[name="year"]');
        let cashRegForm             = $('#pz-kasse-form');
        let actionLinkBox           = $('.pz-link-action-box');
        let filterTextField         = $('#pz-filter-field-main');
        let filterTableRowField     = $('#pz-filter-row-field');
        let filterIcon              = filterTextField.next('.pz-filter-icon');
        let filterTableIcon         = filterTableRowField.next('.pz-filter-table-icon');
        let ticketViewToggle        = $('.pz-ticket-strips .pz-toggle-ticket-view');
        let ippSelect               = $('.pz-footer-grid select');
        let scrollToTopIcon         = $('#scroll-to-top-icon');
        let addEvent2CalendarIcons  = $(".pz-add-ticket-2-time");
        let editTicketPost          = $(".pz-edit-dis-post");
        let ticketEditBtn           = $(".pz-edit-ticket-btn");
        let calendarToggleBtn       = $(".pz-calendar-toggle-btn");
        let printTriggerBtn         = $(".pz-print-button");
        let stdPrintTriggerBtn      = $(".pz-standard-print-button");           // <== USE FOR NON-CUSTOMIZED PRINTS
	    let slidingModal            = null;
	    let PzDialogBox             = null;
	    let toolTippedLinks         = $("*[data-tip]");
	    let calWeekToggle           = $(".pz-cal-week-content-toggle");
	    let salesStatsToggle        = $(".pz-sales-stats-toggle");
	    let formToggle              = $(".pz-close-form");
	    let tableToggles            = $(".pz-card-payments-toggle, .pz-cash-payments-toggle, .pz-debitors-toggle, .pz-cash-expenses-toggle, .pz-summary-toggle");
	    let tableTogglesPlus        = $(".pz-legend-toggle, .pz-shop-sales-toggle, .pz-debits-toggle")
	    let hoverTriggers           = $(".pz-ticket-title .pz-ticket-heading");
	    let snapshotHoverTriggers   = $(".pz-snapshot-hover-trigger .pz-ticket-title");
	    let deleteTriggers          = $("*[data-warn-b4-delete]");
	    let snapshotTicketVToggle   = $("#pz-today-snapshot .pz-toggle-ticket-view");
	    let printBillButton         = $(".pz-print-bill-button");
	    let dateEnabledFields       = $("input[type='date'], input[type='datetime-local'], input.pz-date-picker");
	    let calOpen;
	    const mjrStore              = new PzStorageManager('session', 'mjrTool');
	    const isSafari              = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
	    
	    
	    if(dateEnabledFields.length > 0){
		    dateEnabledFields.datepicker({
			    language: 'de-DE',
			    format  : 'dd.mm.yyyy'
		    });
	    }
	    
	    
	    let cs_tool_tip_config      = {
		    padding:"5px 7px",
		    borderRadius:"7px 0 7px 0",
		    textAlign:"left",
		    letterSpacing:"1px",
		    "box-shadow":"1px -1px 2px rgb(24, 24, 24)",
		    fontSize:"12px",
		    fontWeight:"300",
		    background: "rgba(211, 211, 211, 0.95)",
		    color: "rgba(38, 38, 38, 0.95)"
	    };
	
	    let tooltip_configurator= {
		    hover_duration:3000,
		    bg_width:200,
		    bg_height:305,
		    hover_alpha:1,
		    position:"center",
		    easing:"easeInOutSine",
		    tooltip_div:"div#tooltip",
		    tooltip_resource_attribute:"data-tip",
		    use_tooltip:true,
		    style_object: cs_tool_tip_config
	    };
	    
	    ///// manageCalendarVisibilityStateViaStore();
	    manageCalendarVisibilityStateViaStore();
	
	    function manageCalendarVisibilityStateViaStore(){
		    if(!(calOpen = mjrStore.has('Calendar', 'calendarOpen'))){
			    mjrStore.setProp('Calendar', 'calendarOpen', false);
		    }
		
		    // ALWAYS KEEP CALENDAR OPEN IF THE `calendarOpen` VALUE OF THE `mjrStore` IS TRUE
		    if( mjrStore.getProp('Calendar', 'calendarOpen', false) ){
			    $("#pz-calendar-all").fadeIn();
			    const chevronToggle = calendarToggleBtn.find(".fa");
			    if(chevronToggle.hasClass("pz-toggle-up")){
				   chevronToggle.removeClass("fa-chevron-up");
				   chevronToggle.removeClass("pz-toggle-up");
				   chevronToggle.addClass("fa-chevron-down");
				   chevronToggle.addClass("pz-toggle-down");			    	
			    }
		    }
	    }
	
	    calendarToggleBtn.on("click", function(){
		    if($(this).find(".fa").hasClass("pz-toggle-up")){
			    $(this).find(".fa").removeClass("fa-chevron-up");
			    $(this).find(".fa").removeClass("pz-toggle-up");
			    $(this).find(".fa").addClass("fa-chevron-down");
			    $(this).find(".fa").addClass("pz-toggle-down");
			    mjrStore.setProp('Calendar', 'calendarOpen', true);
			    $("#pz-calendar-all").fadeIn();
		    }else{
			    $(this).find(".fa").removeClass("fa-chevron-down");
			    $(this).find(".fa").removeClass("pz-toggle-down");
			    $(this).find(".fa").addClass("fa-chevron-up");
			    $(this).find(".fa").addClass("pz-toggle-up");
			    mjrStore.setProp('Calendar', 'calendarOpen', false);
			    $("#pz-calendar-all").fadeOut();
		    }
	    });
	
	    toolTippedLinks.cs_tooltip(tooltip_configurator);
	    
	    printTriggerBtn.on("click", function(e){
	    	e.preventDefault();
		    const rayContents = {
		    	e: $("#Rechnung_detail").clone(),
		    	f: $("#bill-number-date").clone(),
		    	g: $("#pz-bill-table").clone(),
		    	h: $("#bill-conditions").clone(),
		    	i: $("#bill-thank-you").clone(),
		    };
		    
		    const prtBox        = $("<div/>", {id: 'pz-wrapper'});
		    const paymentSlip   = `
			<table>
				<tr>
					<td>
					    <div id='payment-slip' style="position:relative;margin=0; background:red;">
					        <h1></h1>
					        <div class="payment-slip-inner" style="position:relative; width:100%;left:0;top:0;">
						        <div class="recipient-info" style="position:absolute;top:12mm;left:3mm;line-height:6.6mm;">
						            <div>Frau Valérie Schelker</div>
						            <div>Kramgasse 39</div>
						            <div>3011 Bern</div>
								</div>
								<div class="mjr-bank-info" style="position:absolute;top:44mm;left:3mm;line-height:6.6mm;">
						            <div>01-96700-25</div>
								</div>
								<div class="payable-bill-amount" style="position:absolute;top:52.8mm;left:29.5mm;line-height:6.6mm;">
						            <div><span style="letter-spacing:3.5mm;">250</span><span style="padding-left:6mm;letter-spacing:3.5mm;">00</span></div>
								</div>
								<div class="payee-contact-info" style="position:absolute;top:66mm;left:3mm;line-height:6.6mm;">
						            <div>Frau Valérie Schelker</div>
						            <div>Kramgasse 39</div>
						            <div>3011 Bern</div>
								</div>
					            <img src="/images/einzahlungsgiro/einzahlungsgiro-xxl-02.png" alt="" class="" id="" style="    width: 100%;
			    display: block; margin: 0 auto; text-align: center;"/>
							</div>
					    </div>
					</td>
				</tr>
			</table>
		    `;
		    
		    prtBox.append(rayContents.e);
		    // prtBox.append($(paymentSlip)); // LEAVE THIS OUT FOR NOW...
		    
		    const pageTitle = document.title;
		    const printData = `<div class='pz-wrapper'>${prtBox.html()}</div>`;
		    const printer   = new Printer(null, printData, $, pageTitle);
		    printer.print();
		    return false;
	    });
	
	    deleteTriggers.on("click", function(e){
	    	e.preventDefault();
		    const data      = $(this).data();
		    const href      = $(this).attr('href');
		    
		    if(data.deleteQuestion === undefined) return true;
		    console.log(data);
		    const confirmationText = `
		      <div class="container">
		        <div class="row">
		            <div class="col-md-12">
		                <div class="jumbotron">
		                    <h1>${data.deleteQuestion}</h1>
		                </div>
		            </div>
		        </div>
		    </div>`;
		    // let slidingModal    = new SlidingModal(confirmationText);
		    // slidingModal.injectRotor();
		    
		    const msg = `<div class=\"jumbotron\">\n<h3 style="color:black;">${data.deleteQuestion}</h3>\n</div>`;
		    const cDialog = PzCustomDialog(msg, 0, true, true, true);
		   
		    cDialog.confirmR.on("click", function(e){
			    console.log('Proceed to delete - ie and afterwards, Return TRUE .....');
			    window.location = href;
			    return true;
		    });
		   
		    cDialog.dismissR.on("click", function(e){
			    console.log('Dismiss Dialog without action.....')
		    });
		    
		    // return true; // IF CONFIRMED... OR  $(this).unbind('click');
	    });
	
	    salesStatsToggle.on("click", function (e) {
		    const indicator         = $(this);
	    	const parent            = indicator.parent(".pz-aside-info");
		    const targetContainer   = parent.next('.pz-all-sales-wrapper');
		
		    toggleIndicatorClass(indicator, targetContainer);
	    });
	    
	    formToggle.on("click", function (e) {
		    const indicator         = $(this);
	    	const parent1           = indicator.parent(".pz-page-title");
	    	const grandParent       = parent1.parent(".pz-page-title-header");
		    const targetContainer   = grandParent.next('.pz-wrapper').find('form');
		    toggleIndicatorClass(indicator, targetContainer);
	    });
	
	    tableToggles.on("click", function (e) {
		    const indicator         = $(this);
	    	const parent            = indicator.parent(".pz-sub-page-heading"); // h5
		    const targetContainer   = parent.next('table');
		    toggleIndicatorClass(indicator, targetContainer);
	    });
	
	    tableTogglesPlus.on("click", function (e) {
		    const indicator         = $(this);
	    	const parent            = indicator.parent(".pz-sub-page-heading"); // h5
		    const targetContainer   = parent.next('.table-responsive');
		    toggleIndicatorClass(indicator, targetContainer);
	    });
	
	    printBillButton.on("click", function(e){
	    	e.preventDefault();
	    	const printBillBtn  = $(this);
	    	const printData     = printBillBtn.data();
	    	
	    	// FETCH THE PRINTABLE HTML CONTENT VIA AJAX AND GIVE IT TO THE PRINTER CLASS
		    const ajaxRequest   = $.ajax({
			    url     : `${printData.endpoint}`,
			    type    : "POST",
			    dataType: "JSON",
		    });
		    
		    ajaxRequest.
		    then(function(printData, textStatus, jqXHR){
			    // IF WE SUCCEED IN FETCHING THE DATA, JUST PASS IT TO THE PRINTER TO PRINT
			    const printer   = new Printer(null, printData.html, $, printData.pageTitle);
			    printer.print();
		    }).
		    catch(function(jqXHR, textStatus, errorThrown){
			    console.log('The following error occurred: ' + textStatus, errorThrown);
		    });
	    	
	    	console.log(printData);
	    });
	    
	    snapshotHoverTriggers.on("mouseover", function (e) {
	    	const parent        = $(this).parent(".pz-snapshot-hover-trigger");
	    	const grandParent   = parent.parent(".pz-snapshot-entries-wrapper");
		    const indicator     = parent.find('.pz-toggle-ticket-view');
		    const ticketContent = grandParent.find('.pz-ticket-posts-group');
		    
		    // HIDE ALL OTHERS EXCEPT THIS:
		    $('#pz-today-snapshot .pz-ticket-posts-group').not(ticketContent).slideUp();    // function(){ $(this).addClass('pz-hidden'); }
		    $('#pz-today-snapshot .pz-toggle-ticket-view').not(indicator).removeClass('fa-angle-up').addClass('fa-angle-down');
		    
		    ticketContent.removeClass('pz-hidden').slideDown();
		    indicator.removeClass('fa-angle-down').addClass('fa-angle-up');
	    });
	    
	    hoverTriggers.on("mouseover", function (e) {
		    const targetParent      = $(this).parent(".pz-ticket-title");
	    	const indicator         = targetParent.find('.pz-toggle-ticket-view');
		    const ticketContent     = targetParent.next('article.pz-ticket-content');
		    const allTicketStrips   = $('.pz-ticket-strips .pz-ticket-content');
		    console.log(ticketContent);
		    
		    const xM     =  allTicketStrips.parent('.pz-current-ticket-strip').find('.pz-toggle-ticket-view');
		    xM.removeClass('fa-angle-up').addClass('fa-angle-down');
		
		    // HIDE ALL OTHERS EXCEPT THIS: // .pz-ticket-strips.pz-grid-2-col
		    allTicketStrips.not(ticketContent).slideUp(500, function(){
		    	$(this).addClass('pz-hidden');
		    });

		    if(ticketContent.hasClass('pz-hidden')){
			    ticketContent.slideDown(500, function(){ $(this).removeClass('pz-hidden'); });
		    }
		    indicator.removeClass('fa-angle-down').addClass('fa-angle-up');
	    });
		
	    yearChooser.on("DD_VALUE_CHANGED", function (e) {
		    let baseURL         = `${window.location.origin}${window.location.pathname}`;
		    const qParamsObj    = getQueryParams();
		    qParamsObj.year     = $(this).val() || e.detail.value;
		    
		    // REMOVE THE WEEK... AND SET DAY TO THE 1ST IF DAY IS GREATER THAN 28
		    if(qParamsObj.week !== undefined){
		    	delete qParamsObj.week;
		    }
		    if(qParamsObj.day !== undefined){
			    if(parseInt(qParamsObj.day, 10) > 28){
				    qParamsObj.day = "01";
			    }
		    }
		    const qParamsStr    = "?" + buildQueryStringFromObject(qParamsObj);
		    window.location     = baseURL + qParamsStr;
	    });
	
	    calWeekToggle.on("click", function(){
		    const parent    = $(this).parentsUntil(".pz-current-ticket-strip").parent(".pz-current-ticket-strip");
		    console.log(parent);
	    	if($(this).hasClass("fa-chevron-up")){
			    $(this).removeClass("fa-chevron-up");
			    $(this).addClass("fa-chevron-down");
			    // $(".pz-cal-week-content").not(parent.find(".pz-cal-week-content")).fadeOut();
			    parent.find(".pz-cal-week-content").slideUp();
		    }else{
			    $(this).removeClass("fa-chevron-down");
			    $(this).addClass("fa-chevron-up");
			    // $(".pz-cal-week-content").not(parent.find(".pz-cal-week-content")).fadeOut();
			    parent.find(".pz-cal-week-content").slideDown();
		    }
	    });
	    
	    addEvent2CalendarIcons.on("django", function (e) {
		    e.preventDefault();
	    	// .pz-hidden-form ---> #pz-ticket-form-block
		    const clonedContent = $('.pz-hidden-form #pz-ticket-form-block').clone(true);
		    let slidingModal    = new SlidingModal(clonedContent.html());
		    slidingModal.injectRotor();
	    });
	
	    ticketEditBtn.on("click", function (e) {
	    	e.preventDefault();
	    	const requestData   = $(this).data();
		    const ajaxRequest   = $.ajax({
			    url     : `/mjr/api/v1/ticket/edit/${requestData.tid}`,
			    type    : "POST",
			    dataType: "JSON",
		    });
		    ajaxRequest.
		    then(function(data, textStatus, jqXHR){
			    loadAjaxForm(data, false, `/mjr/api/v1/ticket/edit`);
		    }).
		    catch(function(jqXHR, textStatus, errorThrown){
			    console.log('The following error occurred: ' + textStatus, errorThrown);
		    });
	    });
	    
	    addEvent2CalendarIcons.on("click", function (e) {
	    	e.preventDefault();
	    	const requestData   = $(this).data();
	    	const date          = requestData.date;
	    	const time          = requestData.time;
		    const ajaxRequest   = $.ajax({
			    url     : `/mjr/api/v1/ticket/new/${time}/${date}`,
			    type    : "POST",
			    dataType: "JSON",
		    });
		    ajaxRequest.
		    then(function(data, textStatus, jqXHR){
			    loadAjaxForm(data);
		    }).
		    catch(function(jqXHR, textStatus, errorThrown){
			    console.log('The following error occurred: ' + textStatus, errorThrown);
		    });
	    });
	
	    editTicketPost.on("click", function (e) {
	    	e.preventDefault();
	    	const requestData   = $(this).data();
	    	const endpoint      = requestData.endpoint;
	    	console.log(requestData);
		    const ajaxRequest   = $.ajax({
			    url     : endpoint,
			    type    : "POST",
			    dataType: "JSON",
		    });
		    ajaxRequest.
		    then(function(data, textStatus, jqXHR){
			    loadAjaxForm(data, false, endpoint);
		    }).
		    catch(function(jqXHR, textStatus, errorThrown){
			    console.log('The following error occurred: ' + textStatus, errorThrown);
		    });
	    });
	
	    cloneCountTriggers.on("focus", function (e) {
	    	$("input#pzProcessForm").val('0');
	    });
	
	    cloneCountTriggers.on("blur", function (e) {
	    	$("input#pzProcessForm").val('1');
	    });
	
	    cloneCountTriggers.on("input", function (e) {
	    	$("input#pzProcessForm").val('0');
	    });
	
	    $("#pzSetCloneButton").on("mousedown", function (e) {
	    	$("input#pzProcessForm").val('0');
	    });
	    
	    cashRegSendBtn.on("mousedown", function (e) {
	    	$("input#pzProcessForm").val('1');
	    });
	
	    filterIcon.on("click", function () {
		    const mainData          = filterTextField.data();
		    const parentsClass      = `${mainData.affectedParentTag}.${mainData.affectedParentClass}`;
		    $(parentsClass).removeClass("hidden");
		    filterTextField.val("");
		    filterTextField.focus();
	    });
	
	    filterTableIcon.on('click', function(){
		    const mainData          = filterTableRowField.data();
		    const parentsClass      = `${mainData.affectedParentTag}.${mainData.affectedParentClass}`;
		    console.log(parentsClass);
		    $(parentsClass).removeClass("hidden");
		    filterTableRowField.val("");
		    filterTableRowField.focus();
	    });
	
	    filterTableRowField.on('input', function(){
		    const main              = $(this);
		    const keyword           = main.val();
		    const mainData          = main.data();   // affectedParentClass, affectedParentTag, filterClass, filterElement
		    const rx                = new RegExp(keyword.replace(/([{}()])/g, '\\$1' ), 'gui');
		    const allRows           = $(`${mainData.affectedParentTag}.${mainData.affectedParentClass}`);
		    if(allRows){
		    	allRows.each(function(){
		    		const singleRow = $(this);
		    		let matchCount  = 0;
				    singleRow.children().each(function(){
					    if( rx.test($(this).text()) ){
						    matchCount++;
					    }
				    });
				    if(!matchCount){
					    singleRow.addClass('hidden');
				    }else{
					    singleRow.removeClass('hidden');
				    }
			    });
		    }
	    });
	    
	    filterTextField.on('input', function(){
	    	const main              = $(this);
	    	const keyword           = main.val();
	    	const mainData          = main.data();   // affectedParentClass, affectedParentTag, filterClass, filterElement
		    const rx                = new RegExp(keyword.replace(/([{}()])/g, '\\$1' ), 'gui');
		    const filterAbleItems   = (mainData.filterClass !== undefined && mainData.filterClass) ?
			                            $(`.${mainData.filterClass}`) :
			                            ((mainData.filterElement !== undefined && mainData.filterElement) ? $(`${mainData.filterElement}`) : []);
		    
		    if(!filterAbleItems.length) return null;
		    
		    filterAbleItems.each( function(item, index){
			    const parentsClass = `${mainData.affectedParentTag}.${mainData.affectedParentClass}`;
			    const targetParent = $(this).parentsUntil(`${parentsClass}`). parent(`${parentsClass}`);
			    if( ! rx.test($(this).text()) ){
			    	targetParent.addClass('hidden');
			    }else{
				    targetParent.removeClass('hidden');
			    }
		    });
        });
    
        scrollToTopIcon.on('click', function(){
            $('html,body').animate({ scrollTop: 0 }, {duration: 750});
        });
        
        ippSelect.on('change', function(){
            let baseURL = `${window.location.origin}${window.location.pathname}/`;
            const newIppVal     = $(this).val();
            const qParamsObj    = getQueryParams();
            qParamsObj.ipp      = newIppVal;
            const qParamsStr    ="?" + buildQueryStringFromObject(qParamsObj);
            window.location     = baseURL + qParamsStr;
        });
	
	    snapshotTicketVToggle.on("click", function (e) {
		    const allTVToggles      = $("#pz-today-snapshot .pz-toggle-ticket-view");
		    const allTicketStrips   = $("#pz-today-snapshot .pz-snapshot-time-group .pz-ticket-posts-group");        // ???
		    const directParent      = $(this).parent(".pz-snapshot-hover-trigger");
		    const grandParent       = directParent.parent(".pz-snapshot-entries-wrapper");
		    const ticketContent     = grandParent.find(".pz-ticket-posts-group");
		    
		    console.log(grandParent);
		    console.log(ticketContent);
		    
		    allTVToggles.not($(this)).removeClass('fa-angle-up').addClass('fa-angle-down');
		    allTicketStrips.not(ticketContent).slideUp(500, function() { $(this).addClass("pz-hidden"); });
		  
		    toggleIndicator($(this));
		
		    if(ticketContent.hasClass('pz-hidden')){
			    ticketContent.slideDown(500, function(){ $(this).removeClass('pz-hidden'); });
		    }else{
			    ticketContent.slideUp(500, function(){ $(this).addClass('pz-hidden'); });
		    }
	    });
	    
	    ticketViewToggle.on("click", function(){
		    const allTVToggles      = $(".pz-ticket-strips .pz-toggle-ticket-view");
		    const allTicketStrips   = $(".pz-current-ticket-strip article");
		    const current           = $(this).parents('.pz-ticket-title').next("article");
		    allTVToggles.not($(this)).removeClass('fa-angle-up').addClass('fa-angle-down');
		    toggleIndicator($(this));
		
		    allTicketStrips.not(current).slideUp(500, function() { $(this).addClass("pz-hidden"); });
		    if(current.hasClass('pz-hidden')){
			    current.slideDown(500, function(){ $(this).removeClass('pz-hidden'); });
		    }else{
			    current.slideUp(500, function(){ $(this).addClass('pz-hidden'); });
		    }
	    });
        
        viewRawPassToggle.on("click", function(e){
            const thisToggle    = $(e.currentTarget);
	        const passwordBox1  = thisToggle.parent("label").next('input');
	        const passwordBox2  = thisToggle.parentsUntil("label").parent("label").next('input');
            const passwordBox   = passwordBox1.length ? passwordBox1 : passwordBox2;
       
            let passwordBoxType = passwordBox.attr('type');
            
            if(passwordBoxType.toLowerCase() === 'password'){
                passwordBox.attr('type', 'text');
            }else{
                passwordBox.attr('type', 'password');
            }
            
            if(thisToggle.hasClass('fa-eye-slash')){
                thisToggle.addClass('fa-eye');
                thisToggle.removeClass('fa-eye-slash');
            }else{
                thisToggle.addClass('fa-eye-slash');
                thisToggle.removeClass('fa-eye');
            }
        });
	
        
	    function toggleIndicatorClass(indicator, targetContainer){
		    if(indicator.hasClass('fa-eye-slash')){
			    indicator.removeClass('fa-eye-slash').addClass('fa-eye');
			    indicator.removeClass('pz-state-on').addClass('pz-state-off');
		    }else{
			    indicator.removeClass('fa-eye').addClass('fa-eye-slash');
			    indicator.removeClass('pz-state-off').addClass('pz-state-on');
		    }
		    targetContainer.fadeToggle();
	    }
	    
	    function mountReceivedAjaxForm(data, hasErrors=false, endpoint=`/mjr/api/v1/ticket/new`){
		    // REMOVE THE SLIDING MODAL, INITIALLY IF THERE'S ONE...
		    if(slidingModal && slidingModal.modalContainer) {
		    	slidingModal.removeRotor();
		    	$(slidingModal.modalContainer).on("ModalHasLeft", function(){
				    loadAjaxForm(data, hasErrors, endpoint);
			    });
		    }
	    }
     
	    function loadAjaxForm(data, hasErrors=false, endpoint=`/mjr/api/v1/ticket/new`){
		    let ajaxForm        = "";
		    if(data){
			    console.log(data);
			    ajaxForm    = `<div class='container'>${data.formWrapOpen}\n${data.formOpen}`;
			    if(data.widgets){
				    for(let formWidget of data.widgets){
				    	// const rxMCE = new RegExp("has-pz-editor tinymce");   if(rxMCE.test(formWidget)){}
					    ajaxForm   += `${formWidget}\n`;
				    }
			    }
			    ajaxForm   += `${data.sendButton}\n${data.formClose}\n${data.formWrapClose}</div>`;
			    slidingModal                = new SlidingModal(ajaxForm);
			    slidingModal.resizeable     = false;
			    slidingModal.modalPosition  = 'top';
			    slidingModal.injectRotor();
			
			    injectTinyMce();
			
			    for(let widgetMeta of data.widgetsMeta) {
				    if (widgetMeta.appType === "drop_down") {
					    const appData       = JSON.parse(widgetMeta.appData);
					    const xRenderer     = new PzRenderer(widgetMeta.appID, appData);
					    xRenderer.renderToView();
					    
					    if(widgetMeta.appValue){
						    console.info('APP-VAL', appData.suggestions[widgetMeta.appValue]);
					    }
				    }
			    }
			    const mainModal = $("#pz-modal-light-box");
			    const submitBTN = mainModal.find("button.btn.pz-form-widget");
			    mainModal.find(".pz-form-widget.form-control").css({'height': '50px'});
			    mainModal.find(".pz-drop-down-wrapper .pz-drop-down-children").css({'width': 'calc(100% - 20px)'});
			    const dtFields  = mainModal.find("input[type='date'], input[type='datetime-local'], input.pz-date-picker");
			
			    if(dtFields.length > 0){
				    dtFields.datepicker({
					    language: 'de-DE',
					    format  : 'dd.mm.yyyy'
				    });
				    $(".datepicker-container").css({zIndex: "9999 !important"})
			    }
			    
			    submitBTN.on('click', function(e){
				    e.preventDefault();
				    const disBtn        = $(this);
				    const newTicketForm = disBtn.parent('form');
				    const formData      = extractFormDataFromForm(newTicketForm);
				
				    handleFormDataShipment(formData, endpoint);
				
				    console.log(newTicketForm);
				    console.log(formData);
			    });
		    }
	    }
	    
	    function handleFormDataShipment(formData, endpoint){
		    const formDataJSON  = JSON.stringify(formData);
		    const ajaxRequest   = $.ajax({
			    url     : endpoint,  // `/mjr/api/v1/ticket/process`,
			    type    : "POST",
			    data    : {'payload': formDataJSON},
			    dataType: "JSON",
		    });
		    ajaxRequest.
		    then(function(data, textStatus, jqXHR){
		    	console.log(data);
		    	if(data.errors){
		    		// RE-MOUNT FORM
				    mountReceivedAjaxForm(data, true, endpoint);
			    }else{
				    mountSuccessFeedBackAndThenReloadPage(data.message);
			    }
		    }).
		    catch(function(jqXHR, textStatus, errorThrown){
			    console.log('The following error occurred: ' + textStatus, errorThrown);
		    });
	    }
	    
	    function mountSuccessFeedBackAndThenReloadPage(message){
	    	// 1ST: REMOVE  THE SLIDING MODAL, INITIALLY IF THERE'S ONE...
		    if(slidingModal && slidingModal.modalContainer) {
			    slidingModal.removeRotor();
			    $(slidingModal.modalContainer).on("ModalHasLeft", function(){
				    // NEXT: BUILD THE STATUS FEEDBACK & MOUNT IT USING THE MODAL...
				    // OR RATHER CONSIDER USING POIZ ALERT....
				    const statusFeedBack        = createTicketSuccessStatusFeedBackHTML(message);
				    
				    // DELAY FOR 3 SECONDS OR SO AND THEN REMOVE THE DIALOG BOX / MODAL
				    PzCustomDialog(statusFeedBack, 1500);
				    $("#pz-custom-dialog").on("DialogRemoved", function(){
					    // RELOAD THE PAGE TO REFRESH VIEW....
					    window.location         = window.location;
				    });
				    /*
				    slidingModal                = new SlidingModal(statusFeedBack);
				    slidingModal.resizeable     = false;
				    slidingModal.modalPosition  = 'top';
				    slidingModal.injectRotor();
				    */
			    });
		    }
	    }
	    
	    function createTicketSuccessStatusFeedBackHTML(message=null) {
	    	message     = (message) ? message : "Das neue Ticket wurde nun erfolgreich erstellt.";
		    return  `
		    <div class="pz-success"
		    	 style="color:#000;padding:40px 20px;font-size:1.75em;">
		    	 <span class="fa fa-check pz-ajax-all-ok-icon" style="color:#000;display:block;text-align:center;margin:0 auto;"></span>
		    	<span class="pz-ajax-message-body" style="display:inline-block">${message}</span>
		    </div>
		    `;
	    }
	    
	    function extractFormDataFromForm($_form, asFormData=false){
	    	let formData        = {};
		    let formDataObj     = new FormData();
		    const formElements  = $_form.find('input, select, textarea');
		    
		    formElements.each(function(){
		    	if(undefined !== $(this).attr('name')){
		    		if($(this).hasClass('has-pz-editor') || $(this).hasClass('tinymce') ){
					    formData[$(this).attr('name')]  = tinymce.activeEditor.getContent();    // $(this).tinymce().getContent();
				    }else{
		    		    formData[$(this).attr('name')]  = $(this).val();
				    }
				    if(asFormData){
					    formDataObj.set($(this).attr('name'), $(this).val());
				    }
			    }
		    });
		    return asFormData ? formDataObj : formData;
	    }
        
        function getQueryParams(){
            const urlParams   = new URLSearchParams(window.location.search);
            const entries   = urlParams.entries();
            let queryParams = {};
            for(let pair of entries) {
                queryParams[pair[0]] = pair[1];
            }
            return queryParams;
        }
        
        function buildQueryStringFromObject(params){
            console.log(params);
            return Object.keys(params).map(key => key + '=' + params[key]).join('&');
        }
        
        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }
        
	    function PzCustomDialog(msgText, delay, removeOnClick=false, addCloseBtn=false, addConfirmR=false) {
		    let body        = $('body');
		    body.find(".pz-custom-dialog").fadeOut(750, function() { PzDialogBox = null; $(this).remove(); });
		    msgText         = (msgText !== undefined) ? msgText : 'Das Bild wurde kopiert!';
		    delay           = (delay !== undefined) ? delay : 2000;
		    const objDim    = getWindowParams();
		    const dismissR  = !addCloseBtn ? '' : `<span class="fa fa-window-close dismissR" style="color:#000000;font-size:24px;cursor:pointer;position:absolute;top:0;right:0;"></span>`;
		    const confirmR  = !addConfirmR ? '' : `<span class="fa fa-check confirmR" style="color:#DC0000;font-size:24px;cursor:pointer;position:absolute;bottom:0;right:0;"></span>`;
		    const message   = `<span
      style='display:block;padding:0 32px;position:relative;margin:0 auto;width:500px;max-width:500px;color:#000000;
      text-align:center;background:rgba(189,189,189,0.9);border-radius:7px;box-shadow: 0 0 2px 2px rgba(0, 0, 0, 0.41);
      font-size:14px;font-weight:500;letter-spacing:0.01em;'>${dismissR}${confirmR}${msgText}</span>`;
		
		    // CREATE WRAPPER OVERLAY-DIV
		    const alertBox    = $('<div />', {
			    id: 'pz-custom-dialog',
			    'class': 'pz-custom-dialog'
		    }).css( {
			    position    : 'fixed',
			    width       : '100%',
			    height      : 'auto',
			    background  : 'transparent',
			    display     : 'none',
			    margin      : 0,
			    padding     : 0,
			    left        : 0,
			    zIndex      : 9999,
			    top         : ((objDim.winHeight - 140) / 2) + 'px'
		    } ).append($(message));
		    body.append(alertBox);
		    const altBox    = body.find(".pz-custom-dialog");
		    const boxTop    = ((objDim.winHeight - (altBox.outerHeight())) / 2) + 'px';
		    altBox.css({top: `${boxTop}`});
		    
		    alertBox.fadeIn(750, function() {
			    if(delay>0){
				    setTimeout(function() {
					    dispatchCustomEvent('DialogRemoved', alertBox.get(0), {status: 0});
					    alertBox.fadeOut(1000, function() { alertBox.remove(); });
				    }, delay);
			    }
		    });
		    
		    if(removeOnClick){
			    alertBox.on("click", function(e){
				    dispatchCustomEvent('DialogRemoved', alertBox.get(0), {status: 0});
				    $(this).fadeOut(1000, function() { $(this).remove(); });
			    });
		    }
		    PzDialogBox = altBox;
		    return {dialogBox: altBox, dismissR: altBox.find(".dismissR"), confirmR: altBox.find(".confirmR") };
	    }
	    
	    function dispatchCustomEvent(eventName, domElement, payload = null) {
		    const event = new CustomEvent(eventName, {detail: payload});
		    domElement.dispatchEvent(event);
		    window.console.log(eventName + ' was dispatched with payload: ...');
		    window.console.log(payload);
	    }
	    
	    function toggleIndicator(indicator){
		    if(indicator.hasClass('fa-angle-up')){
			    indicator.removeClass('fa-angle-up');
			    indicator.addClass('fa-angle-down');
		    }else{
			    indicator.removeClass('fa-angle-down');
			    indicator.addClass('fa-angle-up');
		    }
	    }
	    
	    function getWindowParams() {
		    return {
			    winWidth      : $(window).width(),
			    winHeight     : $(window).height(),
			    docWidth      : $(document).width(),
			    docHeight     : $(document).height(),
			    halfDocHeight : $(window).width(),
		    };
	    }
	    
	    function localizeDatePicker(){
	        $('#l10nCal').change(function() {
		        $('#l10nLanguage').html(formatLanguages($(this).val())).change();
	        });
	
	        $('#l10nLanguage').change(function() {
		        var name = $('#l10nCal').val();
		        var loadName = (name == 'julian' ? '' : name);
		        var lang = $(this).val();
		        if (lang) {
			        $.localise('js/jquery.calendars' + (loadName ? '.' : '') + loadName, lang);
		        }
		        var calendar = $.calendars.instance(name, lang);
		        $('#l10n ul').toggleClass('l10nRTL', calendar.local.isRTL);
		        var list = '';
		        for (var i = 0; i < calendar.local.dayNames.length; i++) {
			        list += '<li>' + calendar.local.dayNames[i] + '</li>';
		        }
		        $('#l10nDays').empty().html(list);
		        list = '';
		        for (var i = 0; i < calendar.local.monthNames.length; i++) {
			        list += '<li>' + calendar.local.monthNames[i] + '</li>';
		        }
		        $('#l10nMonths').empty().html(list);
		        $('#l10nFormat').val(calendar.local.dateFormat);
		        $('#l10nFirstDay').val(calendar.local.dayNames[calendar.local.firstDay]);
	        });
        }
        
        function injectTinyMce(){
	    	let i;
	        if( tinymce.editors.length > 0 ){
		        for( i = 0; i < tinymce.editors.length; i++ ) {
			        tinyMCE.editors[ i ].remove();
		        }
	        }
	
	        tinymce.init({
		        selector: "textarea.has-pz-editor.tinymce",
		        height: 250,
		
		        // without images_upload_url set, Upload tab won't show up
		        images_upload_url: '/mjr/api/v1/upload',
		
		
		        // override default upload handler to simulate successful upload
		        images_upload_handler: function (blobInfo, success, failure) {
			        var xhr, formData;
			
			        xhr     = new XMLHttpRequest();
			        xhr.withCredentials = false;
			        xhr.open('POST', '/mjr/api/v1/upload');
			
			        xhr.onload = function() {
				        let json;
				
				        if (xhr.status !== 200) {
					        failure('HTTP Error: ' + xhr.status);
					        return;
				        }
				
				        json = JSON.parse(xhr.responseText);
				
				        if (!json || typeof json.location != 'string') {
					        failure('Invalid JSON: ' + xhr.responseText);
					        return;
				        }
				        success(json.location);
			        };
			
			        formData = new FormData();
			        formData.append('file', blobInfo.blob(), blobInfo.filename());
			
			        xhr.send(formData);
		        },
		
		        plugins: 'print preview  paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
		        imagetools_cors_hosts: ['picsum.photos'],
		        menubar: 'file edit view insert format tools table help',
		        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
		        toolbar_sticky: true,
		        autosave_ask_before_unload: true,
		        autosave_interval: "30s",
		        autosave_prefix: "{path}{query}-{id}-",
		        autosave_restore_when_empty: false,
		        autosave_retention: "2m",
		        image_advtab: true,
		        content_css: [
			        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
			        '//www.tiny.cloud/css/codepen.min.css'
		        ],
		        link_list: [
			        { title: 'My page 1', value: 'http://www.tinymce.com' },
			        { title: 'My page 2', value: 'http://www.moxiecode.com' }
		        ],
		        image_list: [
			        { title: 'My page 1', value: 'http://www.tinymce.com' },
			        { title: 'My page 2', value: 'http://www.moxiecode.com' }
		        ],
		        image_class_list: [
			        { title: 'None', value: '' },
			        { title: 'Some class', value: 'class-name' }
		        ],
		        importcss_append: true,
		
		        file_picker_callback: function (callback, value, meta) {
			        /* Provide file and text for the link dialog */
			        if (meta.filetype === 'file') {
				        callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
			        }
			
			        /* Provide image and alt text for the image dialog */
			        if (meta.filetype === 'image') {
				        callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
			        }
			
			        /* Provide alternative source and posted for the media dialog */
			        if (meta.filetype === 'media') {
				        callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
			        }
		        },
		        templates: [
			        { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
			        { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
			        { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
		        ],
		        template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
		        template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
		        image_caption: true,
		        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
		        noneditable_noneditable_class: "mceNonEditable",
		        toolbar_drawer: 'sliding',
		        contextmenu: "link image imagetools table",
	        });
        }
        
    });
})(jQuery);