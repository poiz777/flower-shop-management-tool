class Printer{
	_printBox;
	_printBoxHeight;
	_printContent;
	_jqr;
	
	
	constructor(printBox, printContent, jqr) {
		this._printBox      = printBox;
		this._printContent  = printContent;
		this._jqr           = jqr;
	}
	
	setPrintBoxHeight(){}
	
	loadCssOrScriptFile(fileName, fileType, winRef){
		let fileRef;
		if (fileType === "js"){ //if filename is a external JavaScript file
			fileRef = winRef.document.createElement('script');
			fileRef.setAttribute("type","text/javascript");
			fileRef.setAttribute("src", fileName);
		}else if (fileType === "css"){ //if filename is an external CSS file
			fileRef = winRef.document.createElement("link");
			fileRef.setAttribute("rel", "stylesheet");
			fileRef.setAttribute("type", "text/css");
			fileRef.setAttribute("href", fileName);
		}
		if (typeof fileRef!="undefined" && fileRef ) {
			winRef.document.getElementsByTagName("head")[0].appendChild(fileRef);
		}
	}

	print(){
		// CREATE A NEW WINDOW FOR THE PRINTING...
		const newWindow     = window.open("", 'MJR Print Window', 'resizable=1',false);
		// LOAD PRINT-CSS DYNAMICALLY OR ASYNCHRONOUSLY
		newWindow.document.write(`
<html>
	<head>
		<title>Print it!</title>
		<link rel="stylesheet" type="text/css" href="/css/print.css">
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="/css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="/css/melanie-calendar-2.css">
		<link rel="stylesheet" type="text/css" href="/css/melanie.css">
	</head>
`);
		const footer = `
	<section id="print-footer">
	    <footer style="text-align:center;margin:0 auto;width:100%;margin-top:10mm;">
	        <img alt="MJR Logo - Text" src="/images/logos/Melanie_JeanRichard_Logo_OK_01.png" style="margin:0 auto;text-align:center;width:45mm;height:auto;display:block;" />
	        <div style="font-size:8pt;display:block;padding:15px 0px 8px 0px;">JeanRichard-dit-Bressel GmbH</div>
	        <div style="font-size:8.5pt;margin:0;padding:0;">Münstergasse 72&nbsp;&nbsp;&nbsp;3011 Bern&nbsp;&nbsp;&nbsp;031 311 46 79&nbsp;&nbsp;&nbsp;blumen@melaniejeanrichard.ch&nbsp;&nbsp;&nbsp;<a href="http://melaniejeanrichard.ch">melaniejeanrichard.ch</a></div>
	        <div style="font-size:8.5pt;margin:0;padding:0;">IBAN:&nbsp;&nbsp;CH46 0900 0000 6055 9437 4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MwSt. CHE-105.642.287</div>
	    </footer>
	</section>
`;
		const contentPlus = `
	<section id="print-header">
	    <header style="text-align:center; margin:0 auto;width:100%;">
	        <img alt="MJR Logo - Text" src="/images/logos/Logo_MJR_Design.png" style="margin:0 auto;text-align:center;width:18mm;height:auto;display:block;" />
	    </header>
	</section>
	
	<section id="print-block" class="print-block">
		<section class="container">
			<div class="">
				<table class="table print-block-table" id="print-block-table">
					<thead>
						<tr>
							<td>
			                    <div class="header-space">&nbsp;</div>
						    </td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
				                ${this.printContent}
						    </td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td>
				                <div class="footer-space">&nbsp;</div>
						    </td>
						</tr>
					</tfoot>
				</table>
			</div>
		</section>
	</section>
`;
		
		newWindow.setTimeout(()=>{ console.log('Done!!!');
			// CRAFT THE BODY OF THE PRINT-DOCUMENT
			newWindow.document.write("<body class='pz-body-main' id='pz-body-main'>");
			newWindow.document.write(contentPlus);
			newWindow.document.write(footer);
			newWindow.document.write("</body>");
			newWindow.document.write("</html>");
			
			// SEND TO PRINTER AND CLOSE THE WINDOW AFTERWARDS
			newWindow.print();
			newWindow.close();
		
		}, 2000);
		
	}
	
	get printBoxHeight() {
		return this._printBoxHeight;
	}
	
	set printBoxHeight(value) {
		this._printBoxHeight = value;
	}
	
	get printBox() {
		return this._printBox;
	}
	
	set printBox(value) {
		this._printBox = value;
	}
	
	get printContent() {
		return this._printContent;
	}
	
	set printContent(value) {
		this._printContent = value;
	}
	
	get jqr() {
		return this._jqr;
	}
	
	set jqr(value) {
		this._jqr = value;
	}
}
