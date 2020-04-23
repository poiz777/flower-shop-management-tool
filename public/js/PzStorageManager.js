var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var PzStorageManager = /** @class */ (function () {
    function PzStorageManager(_adapter, _namespace) {
        if (_adapter === void 0) { _adapter = 'session'; }
        if (_namespace === void 0) { _namespace = 'default'; }
        this._adapter = _adapter;
        this._namespace = _namespace;
        this._instance = this;
        this._store = {};
        this._data = {};
        this.init();
    }
    PzStorageManager.prototype.init = function () {
        this.bake();
        // console.log('STORAGE INITIALIZED....');
        return this;
    };
    PzStorageManager.prototype.bake = function () {
        if (typeof (Storage) !== 'undefined') {
            this.syncStore();
            this._store[this._namespace] = (this._store[this._namespace] === undefined) ? {} : this._store[this._namespace];
            if (this._adapter === 'session') {
                sessionStorage.setItem(this._namespace, JSON.stringify(this._store));
            }
            else if (this._adapter === 'local') {
                localStorage.setItem(this._namespace, JSON.stringify(this._store));
            }
        }
        else {
            // Sorry! No Web Storage support..
        }
    };
    PzStorageManager.prototype.getProp = function (tKey, prop, defVal) {
        // FIRST CHECK THE DATA STORED IN THE CONTEXT OF THE THIS CLASS VARIABLE
        // IF NOTHING SHOW UP, TRY ACCESSING IT FROM THE STORE...
        // IF ALL FAILS RETURN NULL!!!
        this.syncStore();
        defVal = (defVal === undefined) ? null : defVal;
        if (this._store[this._namespace][tKey] !== undefined) {
            if (this._store[this._namespace][tKey][prop] !== undefined) {
                return this._store[this._namespace][tKey][prop];
            }
        }
        return defVal;
    };
    PzStorageManager.prototype.getAll = function (tKey, defVal) {
        this.syncStore();
        defVal = (defVal === undefined) ? {} : defVal;
        if (this._store[this._namespace][tKey] === undefined) {
            return defVal;
        }
        return this._store[this._namespace][tKey];
    };
    PzStorageManager.prototype.setProp = function (tKey, prop, propValue) {
        this.syncStore();
        if (this._store[this._namespace][tKey] === undefined) {
            this._store[this._namespace][tKey] = this._data;
        }
        this._store[this._namespace][tKey][prop] = propValue;
        // SAVE IMMEDIATELY TO STORE:
        this.save();
    };
    PzStorageManager.prototype.add = function (tKey, prop, propValue) {
        this.setProp(tKey, prop, propValue);
    };
    PzStorageManager.prototype.setAdapter = function (adapter) {
        this._adapter = adapter;
    };
    PzStorageManager.prototype.has = function (tKey, prop) {
        this.syncStore();
        if (this._store[this._namespace][tKey] !== undefined) {
            if (this._store[this._namespace][tKey][prop] !== undefined) {
                return true;
            }
        }
        return false;
    };
    PzStorageManager.prototype.hasKey = function (tKey) {
        return (this._store[this._namespace][tKey] !== undefined);
    };
    PzStorageManager.prototype.storeHasKey = function (key) {
        if (typeof (Storage) !== 'undefined') {
            var storedData = null;
            if (this._adapter === 'session') {
                storedData = sessionStorage.getItem(this._namespace);
            }
            else if (this._adapter === 'local') {
                storedData = localStorage.getItem(this._namespace);
            }
            if (storedData !== undefined && storedData) {
                var nSpacedData = JSON.parse(storedData);
                return nSpacedData[key];
            }
            return false;
        }
        else {
            alert('This App will not run very well without Web Storage Support on your Browsers.\nPlease, install a Modern Browser with Web-Storage Support...');
        }
        return false;
    };
    PzStorageManager.extend = function () {
        var restArgs = [];
        for (var _i = 0; _i < arguments.length; _i++) {
            restArgs[_i] = arguments[_i];
        }
        if (restArgs.length < 1) {
            return null;
        }
        for (var i = 1; i < arguments.length; i++) {
            for (var key in arguments[i]) {
                if (arguments[i].hasOwnProperty(key)) {
                    arguments[0][key] = arguments[i][key];
                }
            }
        }
        return arguments[0];
    };
    PzStorageManager.prototype.syncStore = function () {
        // GET DATA FROM STORAGE IF IT EXISTS....
        // HOWEVER, IF WE HAVE A CLASS-SCOPE EQUIVALENT,
        // WE USE IT TO OVERRIDE THAT FROM STORAGE...
        var storedData = null;
        var confData = {};
        if (this._adapter === 'session') {
            storedData = sessionStorage.getItem(this._namespace);
        }
        else if (this._adapter === 'local') {
            storedData = localStorage.getItem(this._namespace);
        }
        if (storedData !== undefined && storedData) {
            confData = JSON.parse(storedData);
        }
        this._store = PzStorageManager.extend({}, this._store, confData);
        // this._store = Object.assign({}, this._store, confData);
    };
    PzStorageManager.prototype.save = function () {
        if (typeof (Storage) !== 'undefined') {
            if (this._adapter === 'session') {
                sessionStorage.setItem(this._namespace, JSON.stringify(this._store));
            }
            else if (this._adapter === 'local') {
                localStorage.setItem(this._namespace, JSON.stringify(this._store));
            }
        }
        else {
            // Sorry! No Web Storage support..
        }
    };
    Object.defineProperty(PzStorageManager.prototype, "store", {
        get: function () {
            return this._store;
        },
        set: function (value) {
            this._store = value;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(PzStorageManager.prototype, "data", {
        get: function () {
            return this._data;
        },
        set: function (value) {
            this._data = value;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(PzStorageManager.prototype, "adapter", {
        get: function () {
            return this._adapter;
        },
        set: function (value) {
            this._adapter = value;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(PzStorageManager.prototype, "namespace", {
        get: function () {
            return this._namespace;
        },
        set: function (value) {
            this._namespace = value;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(PzStorageManager.prototype, "instance", {
        get: function () {
            return this._instance;
        },
        set: function (value) {
            this._instance = value;
        },
        enumerable: true,
        configurable: true
    });
    return PzStorageManager;
}());
var ObjectPlus = /** @class */ (function (_super) {
    __extends(ObjectPlus, _super);
    function ObjectPlus() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    ObjectPlus.size = function (obj) {
        var size = 0;
        var key;
        for (key in obj) {
            if (obj.hasOwnProperty(key))
                size++;
        }
        return size;
    };
    return ObjectPlus;
}(Object));
