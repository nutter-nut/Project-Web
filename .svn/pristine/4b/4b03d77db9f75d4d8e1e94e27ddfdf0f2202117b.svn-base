function panelToggle(panel_value, open){
    var form_panel = document.getElementById('form-panel-'+panel_value);
    var panel = document.getElementById('panel-' + panel_value);
    if(open){
        panel.className = "panel-toggle";
        panel.setAttribute("onClick", "panelToggle('"+panel_value+"', false)");
        form_panel.style.display = "none";
    }else{
        panel.className = "active panel-toggle";
        panel.setAttribute("onClick", "panelToggle('"+panel_value+"', true)");
        form_panel.style.display = "block";
    }
}

function openFilter(){
    var x = document.getElementById('criteria-container');
    x.className = 'col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 sidebar';
}

function closeFilter(){
    var x = document.getElementById('criteria-container');
    x.className = 'col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 sidebar hidden-xs';
}