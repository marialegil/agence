$('#consultores').multiselect({
    enableFiltering: true,
    enableHTML: true,
    buttonClass: 'btn btn-lg btn-default consultores',
    buttonWidth: '100%',
    nonSelectedText: 'Seleccione Consultores',

    templates: {
    button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown"><span class="multiselect-selected-text"></span> &nbsp;<b class="fa fa-caret-down"></b></button>',
    ul: '<ul class="multiselect-container dropdown-menu"></ul>',
    filter: '<li class="multiselect-item filter"><div class="input-group"><span class="input-group-addon"><i class="fa fa-search"></i></span><input class="form-control multiselect-search" type="text"></div></li>',
    filterClearBtn: '<span class="input-group-btn"><button class="btn btn-default btn-white btn-grey multiselect-clear-filter" type="button"><i class="fa fa-times-circle red2"></i></button></span>',
    li: '<li><a tabindex="0"><label></label></a></li>',
        divider: '<li class="multiselect-item divider"></li>',
        liGroup: '<li class="multiselect-item multiselect-group"><label></label></li>'
   }
});

$('#desde_mes, #desde_ano, #hasta_mes, #hasta_ano').multiselect({
    enableFiltering: true,
    enableHTML: true,
    buttonClass: 'btn btn-default',
    buttonWidth: '5%%',

    templates: {
    button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown"><span class="multiselect-selected-text"></span> &nbsp;<b class="fa fa-caret-down"></b></button>',
    ul: '<ul class="multiselect-container dropdown-menu"></ul>',
    filter: '<li class="multiselect-item filter"><div class="input-group"><span class="input-group-addon"><i class="fa fa-search"></i></span><input class="form-control multiselect-search" type="text"></div></li>',
    filterClearBtn: '<span class="input-group-btn"><button class="btn btn-default btn-white btn-grey multiselect-clear-filter" type="button"><i class="fa fa-times-circle red2"></i></button></span>',
    li: '<li><a tabindex="0"><label></label></a></li>',
        divider: '<li class="multiselect-item divider"></li>',
        liGroup: '<li class="multiselect-item multiselect-group"><label></label></li>'
   }
});


function makeCanvas(response) {
    var canvas = '<canvas id="myChart" width="50%" height="60px"></canvas>';

    var data = response;
    var div = $('#vista');
    $('#relatorio').empty();        
    div.empty();
    div.append(canvas);

    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, data);
}

function relatorio(){
    
    var raiz = $('#raiz').attr('data-url');
    var desde_mes = $('#desde_mes').val();
    var desde_ano = $('#desde_ano').val();
    var hasta_mes = $('#hasta_mes').val();
    var hasta_ano = $('#hasta_ano').val();
    var selected=[];

    $('#consultores > option:selected').each(function(){
        selected.push(this.value);
    });

    if(selected.length == 0){

        alert("Debe Seleccionar Consultores");
        $('.consultores').removeClass('btn-default');
        $('.consultores').addClass('btn btn-warning');
        $('#vista').empty();
        $('#relatorio').empty();        
        return 0;
    }
        $('.consultores').addClass('btn-default');
        $('.consultores').removeClass('btn-danger');

    data = {
        desde_mes:desde_mes,
        desde_ano:desde_ano,
        hasta_mes:hasta_mes,
        hasta_ano:hasta_ano,
        usuarios:selected,

    }
    $.get(raiz+'/relatorio', data).done(function(res){
        $('#vista').empty();
        $('#relatorio').empty();        
        $('#relatorio').append(res);
    });

}


function grafico(){
    var raiz = $('#raiz').attr('data-url');
    var desde_mes = $('#desde_mes').val();
    var desde_ano = $('#desde_ano').val();
    var hasta_mes = $('#hasta_mes').val();
    var hasta_ano = $('#hasta_ano').val();
    var selected=[];

    $('#consultores > option:selected').each(function(){
        selected.push(this.value);
    });
    if(selected.length == 0){
        alert("Debe Seleccionar Consultores");
        $('.consultores').removeClass('btn-default');
        $('.consultores').addClass('btn-success');
        $('#vista').empty();
        $('#relatorio').empty();        
        return 0;
    }
    $('.consultores').addClass('btn-default');
    $('.consultores').removeClass('btn-danger');   


    data = {
        desde_mes:desde_mes,
        desde_ano:desde_ano,
        hasta_mes:hasta_mes,
        hasta_ano:hasta_ano,
        usuarios:selected,
    }



    $.get(raiz+'/grafico', data).done(function(res){

        if (res[0] != undefined && res[0] == 'cero') {
            alert('El Usuario no tiene registros');
            $('.consultores').removeClass('btn-default');
            $('.consultores').addClass('btn-success');
            $('#vista').empty();
            $('#relatorio').empty();  
            return 0;           
        }
        $('.consultores').addClass('btn-default');
        $('.consultores').removeClass('btn-danger');  
        makeCanvas(res)

    });        
}

function pizza(){
    var raiz = $('#raiz').attr('data-url');
    var desde_mes = $('#desde_mes').val();
    var desde_ano = $('#desde_ano').val();
    var hasta_mes = $('#hasta_mes').val();
    var hasta_ano = $('#hasta_ano').val();
    var selected=[];

    $('#consultores > option:selected').each(function(){
        selected.push(this.value);
    });
    if(selected.length == 0){
        alert("Debe Seleccionar Consultores");
        $('.consultores').removeClass('btn-default');
        $('.consultores').addClass('btn btn-info');
        $('#vista').empty();
        $('#relatorio').empty();                
        return 0;
    }
    $('.consultores').addClass('btn-default');
    $('.consultores').removeClass('btn-danger');    
    data = {
        desde_mes:desde_mes,
        desde_ano:desde_ano,
        hasta_mes:hasta_mes,
        hasta_ano:hasta_ano,
        usuarios:selected,
    }

    $.get(raiz+'/pizza', data).done(function(res){
        makeCanvas(res)

    });        
}