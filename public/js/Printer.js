var Printer = /** @class */ (function () {
    function Printer(printBox, printContent, jqr) {
        this._printBox = printBox;
        this._printContent = printContent;
        this._jqr = jqr;
    }
    Printer.prototype.setPrintBoxHeight = function () { };
    Printer.prototype.loadCssOrScriptFile = function (fileName, fileType, winRef) {
        var fileRef;
        if (fileType === "js") { //if filename is a external JavaScript file
            fileRef = winRef.document.createElement('script');
            fileRef.setAttribute("type", "text/javascript");
            fileRef.setAttribute("src", fileName);
        }
        else if (fileType === "css") { //if filename is an external CSS file
            fileRef = winRef.document.createElement("link");
            fileRef.setAttribute("rel", "stylesheet");
            fileRef.setAttribute("type", "text/css");
            fileRef.setAttribute("href", fileName);
        }
        if (typeof fileRef != "undefined" && fileRef) {
            winRef.document.getElementsByTagName("head")[0].appendChild(fileRef);
        }
    };
    Printer.prototype.print = function () {
        // CREATE A NEW WINDOW FOR THE PRINTING...
        var newWindow   = window.open("", 'MJR Print Window', 'resizable=1', false);
        // LOAD PRINT-CSS DYNAMICALLY OR ASYNCHRONOUSLY
        newWindow.document.write("\n<html>\n\t<head>\n\t\t<title>Print it!</title>\n\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"/css/print.css\">\n\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"/css/bootstrap.min.css\">\n\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"/css/font-awesome.css\">\n\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"/css/melanie-calendar-2.css\">\n\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"/css/melanie.css\">\n\t</head>\n");
        var footer      = "\n\t<section id=\"print-footer\">\n\t    <footer style=\"text-align:center;margin:0 auto;width:100%;\">\n\t        <img alt=\"MJR Logo - Text\" src=\"/images/logos/Melanie_JeanRichard_Logo_OK_01.png\" style=\"margin:0 auto;text-align:center;width:45mm;height:auto;display:block;\" />\n\t        <div style=\"font-size:8pt;display:block;padding:15px 0px 8px 0px;\">JeanRichard-dit-Bressel GmbH</div>\n\t        <div style=\"font-size:8.5pt;margin:0;padding:0;\">M\u00FCnstergasse 72&nbsp;&nbsp;&nbsp;3011 Bern&nbsp;&nbsp;&nbsp;031 311 46 79&nbsp;&nbsp;&nbsp;blumen@melaniejeanrichard.ch&nbsp;&nbsp;&nbsp;<a href=\"http://melaniejeanrichard.ch\">melaniejeanrichard.ch</a></div>\n\t        <div style=\"font-size:8.5pt;margin:0;padding:0;\">IBAN:&nbsp;&nbsp;CH46 0900 0000 6055 9437 4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MwSt. CHE-105.642.287</div>\n\t    </footer>\n\t</section>\n";
        var contentPlus = "\n\t<section id=\"print-header\">\n\t    <header style=\"text-align:center; margin:0 auto;width:100%;margin-top:10mm;\">\n\t        <img alt=\"MJR Logo - Text\" src=\"/images/logos/Logo_MJR_Design.png\" style=\"margin:0 auto;text-align:center;width:18mm;height:auto;display:block;\" />\n\t    </header>\n\t</section>\n\t\n\t<section id=\"print-block\" class=\"print-block\">\n\t\t<section class=\"container\">\n\t\t\t<div class=\"\">\n\t\t\t\t<table class=\"table print-block-table\" id=\"print-block-table\">\n\t\t\t\t\t<thead>\n\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<td>\n\t\t\t                    <div class=\"header-space\">&nbsp;</div>\n\t\t\t\t\t\t    </td>\n\t\t\t\t\t\t</tr>\n\t\t\t\t\t</thead>\n\t\t\t\t\t<tbody>\n\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<td>\n\t\t\t\t                " + this.printContent + "\n\t\t\t\t\t\t    </td>\n\t\t\t\t\t\t</tr>\n\t\t\t\t\t</tbody>\n\t\t\t\t\t<tfoot>\n\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<td>\n\t\t\t\t                <div class=\"footer-space\">&nbsp;</div>\n\t\t\t\t\t\t    </td>\n\t\t\t\t\t\t</tr>\n\t\t\t\t\t</tfoot>\n\t\t\t\t</table>\n\t\t\t</div>\n\t\t</section>\n\t</section>\n";
        newWindow.setTimeout(function () {
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
    };
    Object.defineProperty(Printer.prototype, "printBoxHeight", {
        get: function () {
            return this._printBoxHeight;
        },
        set: function (value) {
            this._printBoxHeight = value;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(Printer.prototype, "printBox", {
        get: function () {
            return this._printBox;
        },
        set: function (value) {
            this._printBox = value;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(Printer.prototype, "printContent", {
        get: function () {
            return this._printContent;
        },
        set: function (value) {
            this._printContent = value;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(Printer.prototype, "jqr", {
        get: function () {
            return this._jqr;
        },
        set: function (value) {
            this._jqr = value;
        },
        enumerable: true,
        configurable: true
    });
    return Printer;
}());