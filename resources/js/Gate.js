export default class Gate{

    constructor(roles, permissions){
        
        // ROLE PART
        this.roles = [];
        // merge if role is more than one!
        for(var i=0; i<roles.length; i++) {
            this.roles = this.roles.concat(roles[i]['name']);
        }
        console.log(this.roles);

        // PERMISSION PART
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

    isShopOwnerOrAdmin(permission){
        // first check permission, then the shop... 
        if(this.permissions.includes(permission)) {
            if(this.roles.includes('superadmin')) {
                return true;
            } 
            // else if() {

            // }
        }
    }
}