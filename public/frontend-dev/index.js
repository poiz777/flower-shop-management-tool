import $ from 'jquery';
import PreLoader    from './js/pzj/modules/PreLoader';
import PzDialog     from './js/pzj/modules/PzDialog';
import Validator    from './js/pzj/modules/Validator';


(function($){
	$(document).ready(function($){
		let dialog;
		let resourceName            = $(".pz-resource-name");
		let dataInfoViewPane        = $("#pz-file-info-view-pane");
		let dataInfoViewerTrigger   = $(".pz-info");    //.pz-hover-area;
		let allBSDivs               = $("div[id*='w50_']");   //  , div[id*='pz_jobs']
		let groupOnes               = $("div[id*='__group_1__']");   //  , div[id*='pz_jobs']
		let groupTwos               = $("div[id*='__group_2__']");   //  , div[id*='pz_jobs']
		let groupThrees             = $("div[id*='__group_3__']");   //  , div[id*='pz_jobs']
		let assetTrashTrigger       = $(".pz-trash");   //  , div[id*='pz_jobs']
		let preLoader               = new PreLoader($, "http://odaumwelt.pz/wp-content/plugins/PzJobs/FrontEnd/Images/icons/ring-loader-256.gif");
		
		console.log(groupOnes);
		
		
		dataInfoViewerTrigger.on("click", function(){
			$(".pz-info").not($(this)).attr("data-info-clicked", "0").data("clicked", false);
			const parent = $(this).parent('div');   //.pz-thumb-icon .pz-flex-child
			const infoViewer    = parent.find('.pz-file-info-box');
			if(!$(this).data("clicked")){ $(this).data("clicked", false);  $(this).attr("data-info-clicked", "0");}
			if(!$(this).data("clicked")){
				dialog              = PoizCustomDialog(infoViewer.html(), 0, 'TOP_CENTER');
			}else{
				dialog.fadeOut(750, function(){ $(this).remove();});
			}
			$(this).data("clicked", !$(this).data("clicked"));
			$(this).attr("data-info-clicked", ($(this).attr("data-info-clicked") === "0") ? "1" : "0" );
			// dataInfoViewPane.html(infoViewer.html());
			// dataInfoViewPane.fadeIn(750, function(){});
			console.log($(this).data());
		});
		
		$(document).on("click", function(e){
			const altBox    = $(document).find(".klink-pixxio-form-dialog");
			if(altBox && altBox.get(0) && altBox.get(0).contains(e.target)){
				altBox.fadeOut(750, function(){ $(this).remove();});
				$(".pz-info").attr("data-info-clicked", "0").data("clicked", false);
			}
		});
		const groupParent       = groupOnes.first().parent();
		// const group1Clone    = groupOnes.clone(true, true);
		// const group2Clone    = groupTwos.clone(true, true);
		const group1Wrapper     = $("<div />", {class: 'pz-fields-group-block', id: 'pz-fields-group-block-1'});
		const group2Wrapper     = $("<div />", {class: 'pz-fields-group-block', id: 'pz-fields-group-block-2'});
		const group1BoxInner    = $("<div />", {class: 'pz-fields-group-box-inner', id: 'pz-fields-group-box-inner-1'});
		const group2BoxInner    = $("<div />", {class: 'pz-fields-group-box-inner', id: 'pz-fields-group-box-inner-2'});
		//groupOnes.remove();
		// groupTwos.remove();
		
		assetTrashTrigger.on("click", function(){
			const main      = $(this);
			const payload   = $(this).data();
			const endPoint  = php_array.admin_ajax;
			payload.action  = 'manage_pzj_file_uploads';
			payload.intent  = 'deletePzjFileAndAssociateMetaData';
			payload.doable  = 'deletePzjFileAndAssociateMetaData';
			
			$.ajax({
				url: endPoint,
				dataType: "json",
				cache: false,
				type: "POST",
				data: payload,
				success: function (data, textStatus, jqXHR) {
					data    = JSON.parse(data);
					if(data.status){
						const dialog = PoizCustomDialog(data.status, 1000);
						main.parent('div.pz-thumb-icon.pz-grid-child').fadeOut(750, function(){ $(this).remove(); });
					}
					console.log(data);
				},
				
				error: function (jqXHR, textStatus, errorThrown) {
					console.log('The following error occurred: ' + textStatus, errorThrown);
				},
				
				complete: function (jqXHR, textStatus) {
					preLoader.remove();
				},
				
				beforeSend: function(){
					preLoader.show();
				}
			});
			
			console.log(endPoint);
			console.log(payload);
		});
		group1Wrapper.append("<h1>Yeee</h1>");
		group1BoxInner.append(groupOnes);
		group1Wrapper.append(group1BoxInner);
		
		group2Wrapper.append("<h1>Hurray!!!</h1>");
		group2BoxInner.append(groupTwos);
		group2Wrapper.append(group2BoxInner);
		
		function runBaseLoop(){
			groupOnes.each(function(cue, el){
				console.log(cue, el);
				if(cue % 2 === 0 ){ //&& cue !== 1
					$(el).addClass('pz-even pz-k-' + cue);
				}else{
					$(el).addClass('pz-odd pz-k-' + cue);
				}
			});
			
			groupTwos.each(function(cue, el){
				console.log(cue, el);
				if(cue % 2 === 0 ){ //&& cue !== 1
					$(el).addClass('pz-even pz-k-' + cue);
				}else{
					$(el).addClass('pz-odd pz-k-' + cue);
				}
			});
		}
		// runBaseLoop();
		
		groupParent.prepend(group2Wrapper);
		groupParent.prepend(group1Wrapper);
		console.log(groupParent);
		
		console.log(groupOnes);
		
		groupParent.find(".pz-fields-group-block h1").on("click", function(e){
			const parent = $(this).parent('div');
			console.log(parent);
			parent.find('.pz-fields-group-box-inner').slideToggle(750, function(){
				if($(this).css('display') === 'block'){
					$(this).css({display: 'grid'});
				}
			});
			runBaseLoop();
		});
		
		
		function PoizCustomDialog(msgText, delay, location='CENTER_CENTER') {
			let body        = $('body');
			body.find(".klink-pixxio-form-dialog").fadeOut(750, function() { dialog = null; $(this).remove(); });
			msgText         = (msgText !== undefined) ? msgText : 'Das Bild wurde kopiert!';
			delay           = (delay !== undefined) ? delay : 2000;
			const objDim    = getWindowParams();
			const message   = `<div
      class='pz-dialog-main'
      id='pz-dialog-main'
      style='
      display:block;
      padding:20px 20px; /*0 32px;   30px*/
      margin:0 auto;
      width:500px;
      max-width:500px;
      box-sizing: border-box;
      color:#000000;
      background:white; /*rgba(189,189,189,0.9);*/
      border-radius:7px;
      box-shadow: 0 0 2px 2px rgba(0, 0, 0, 0.41);
      font-size:10px;
      font-weight:500;
      letter-spacing:0.01em;
    -webkit-hyphens: auto;
    -moz-hyphens: auto;
    -ms-hyphens: auto;
    hyphens: auto;
    -ms-word-break: break-all;
    word-break: break-all;
    word-break: break-word;
      /*border:double 3px rgba(255,255,255,0.4);*/'>${msgText}</div>`;
			
			// CREATE WRAPPER OVERLAY-DIV
			const alertBox    = $('<div />', {
				id: 'pz-alert',
				'class': 'pz-alert klink-pixxio-form-dialog'
			}).css( {
				position    : 'fixed',
				width       : '100%',
				height      : 'auto',
				background  : 'transparent',
				display     : 'none',
				margin      : 0,
				padding     : 0,
				left        : 0,
				zIndex      : 9999999999,
				top         : ((objDim.winHeight - 140) / 2) + 'px'
			} ).append($(message));
			body.append(alertBox);
			const altBox    = body.find(".klink-pixxio-form-dialog");
			const boxTop    = ((objDim.winHeight - (altBox.outerHeight())) / 2) + 'px';
			let style1, style2;
			if(location === 'CENTER_CENTER'){
				style1      = {top: `${boxTop}`};
				style2      = {};
			}else if(location === 'TOP_CENTER'){
				style1      = {top: `0`};
				style2      = {};
			}else if(location === 'BOTTOM_CENTER'){
				style1      = {};
				style2      = {bottom: `0`, position: 'default'};
			}else if(location === 'BOTTOM_LEFT'){
				style1      = {};
				style2      = {bottom: `0`, left: '0', right:'auto', margin: 'auto', position: 'absolute', top: 'auto'};
			}else if(location === 'BOTTOM_RIGHT'){
				style1      = {};
				style2      = {bottom: `0`, left: 'auto', right:'0', margin: 'auto', position: 'absolute', top: 'auto'};
			}else if(location === 'TOP_LEFT'){
				style1      = {top: `0`};
				style2      = {bottom: `auto`, left: '0', right:'auto', margin: 'auto', position: 'absolute', top: '0'};
			}else if(location === 'TOP_RIGHT'){
				style1      = {top: `0`};
				style2      = {bottom: `auto`, left: 'auto', right:'0', margin: 'auto', position: 'absolute', top: '0'};
			}else if(location === 'RIGHT_CENTER' || location === 'CENTER_RIGHT'){
				style1      = {top: `${boxTop}`};
				style2      = {bottom: `auto`, left: 'auto', right:'0', margin: 'auto', position: 'absolute', top: 'auto'};
			}else if(location === 'LEFT_CENTER' || location === 'CENTER_LEFT'){
				style1      = {top: `${boxTop}`};
				style2      = {bottom: `auto`, left: '0', right:'auto', margin: 'auto', position: 'absolute', top: 'auto'};
			}
			altBox.find('.pz-dialog-main').css(style2);
			altBox.css(style1);
			
			
			alertBox.fadeIn(750, function() {
				if(delay>0){
					setTimeout(function() {
						alertBox.fadeOut(1000, function() { alertBox.remove(); });
					}, delay);
				}
			});
			dialog = altBox;
			return altBox;
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
		
		
	});
})(jQuery);


