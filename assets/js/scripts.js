$(document).ready(function(){
    var sidenav = $('.layout-cell.layout-sidenav-container ul.nav').html();
    $('.layout-cell.layout-sidenav-container').remove();
    if(sidenav !== undefined){
        $('#layout-canvas > .layout > .layout-row.min-size').after('<div class="layout-row min-size"><div class="layout-sidenav control-toolbar bg-p"><div class="toolbar-item toolbar-primary"><div data-control="toolbar" data-disposable"><ul class="nav">'+sidenav+'</ul></div></div></div></div>');
    }
});
