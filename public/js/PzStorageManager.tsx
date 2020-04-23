class PzStorageManager {
    _adapter;
    _namespace;
    _instance;
    _store;
    _data;
    
    constructor(_adapter = 'session', _namespace = 'default') {
        this._adapter = _adapter;
        this._namespace = _namespace;
        this._instance = this;
        this._store = {};
        this._data = {};
        this.init();
    }
    
    init() {
        this.bake();
        // console.log('STORAGE INITIALIZED....');
        return this;
    }
    
    bake() {
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
    }
    
    getProp(tKey, prop, defVal) {
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
    }
    
    getAll(tKey, defVal) {
        this.syncStore();
        defVal = (defVal === undefined) ? {} : defVal;
        if (this._store[this._namespace][tKey] === undefined) {
            return defVal;
        }
        return this._store[this._namespace][tKey];
    }
    
    setProp(tKey, prop, propValue) {
        this.syncStore();
        if (this._store[this._namespace][tKey] === undefined) {
            this._store[this._namespace][tKey] = this._data;
        }
        this._store[this._namespace][tKey][prop] = propValue;
        // SAVE IMMEDIATELY TO STORE:
        this.save();
    }
    
    add(tKey, prop, propValue) {
        this.setProp(tKey, prop, propValue);
    }
    
    setAdapter(adapter) {
        this._adapter = adapter;
    }
    
    has(tKey, prop) {
        this.syncStore();
        if (this._store[this._namespace][tKey] !== undefined) {
            if (this._store[this._namespace][tKey][prop] !== undefined) {
                return true;
            }
        }
        return false;
    }
    
    hasKey(tKey) {
        return (this._store[this._namespace][tKey] !== undefined);
    }
    
    storeHasKey(key) {
        if (typeof (Storage) !== 'undefined') {
            let storedData = null;
            if (this._adapter === 'session') {
                storedData = sessionStorage.getItem(this._namespace);
            }
            else if (this._adapter === 'local') {
                storedData = localStorage.getItem(this._namespace);
            }
            if (storedData !== undefined && storedData) {
                let nSpacedData = JSON.parse(storedData);
                return nSpacedData[key];
            }
            return false;
        }
        else {
            alert('This App will not run very well without Web Storage Support on your Browsers.\nPlease, install a Modern Browser with Web-Storage Support...');
        }
        return false;
    }
    
    static extend(...restArgs) {
        if (restArgs.length < 1) {
            return null;
        }
        for (let i = 1; i < arguments.length; i++) {
            for (let key in arguments[i]) {
                if (arguments[i].hasOwnProperty(key)) {
                    arguments[0][key] = arguments[i][key];
                }
            }
        }
        return arguments[0];
    }
    
    syncStore() {
        // GET DATA FROM STORAGE IF IT EXISTS....
        // HOWEVER, IF WE HAVE A CLASS-SCOPE EQUIVALENT,
        // WE USE IT TO OVERRIDE THAT FROM STORAGE...
        let storedData = null;
        let confData = {};
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
    }
    
    save() {
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
    }
    
    get store() {
        return this._store;
    }
    
    get data() {
        return this._data;
    }
    
    get adapter() {
        return this._adapter;
    }
    
    get namespace() {
        return this._namespace;
    }
    
    get instance() {
        return this._instance;
    }
    
    set store(value) {
        this._store = value;
    }
    
    set data(value) {
        this._data = value;
    }
    
    set adapter(value) {
        this._adapter = value;
    }
    
    set namespace(value) {
        this._namespace = value;
    }
    
    set instance(value) {
        this._instance = value;
    }
}

class ObjectPlus extends Object {
    static size(obj) {
        let size = 0;
        let key;
        for (key in obj) {
            if (obj.hasOwnProperty(key))
                size++;
        }
        return size;
    }
}