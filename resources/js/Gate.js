export default class Gate{

    constructor(permissions){
        this.permissions = [];
        // merge if role is more than one!
        for(var i=0; i<permissions.length; i++) {
            this.permissions = this.permissions.concat(permissions[i]['permissions']);
        }

        // make an array of names only!
        this.permissionsnames = [];
        for(var i=0; i<this.permissions.length; i++) {
            this.permissionsnames = this.permissionsnames.concat(this.permissions[i]['name']);
        }

        // filter the array from duplicates!
        var permissionsnames2 = [];
        $.each(this.permissionsnames, function(i, el){
            if($.inArray(el, permissionsnames2) === -1) permissionsnames2.push(el);
        });
        console.log(permissionsnames2);

        // Finally...
        this.permissions = permissionsnames2;
    }


    isAuthorized(permission){
        if(this.permissions.includes(permission)) {
            return true;
        }
    }
}