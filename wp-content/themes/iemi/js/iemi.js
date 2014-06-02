jQuery(document).ready(function(e){
    
    jQuery(".panes").cycle({
        fx:'fade',
        pause:  1,
        timeout:  7500,
        speed:  1500
    });
    
    
    
    
})

/* Máscaras ER */
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}
function id( el ){
	return document.getElementById( el );
}
                                      
function analisa_codigo_pais(o){
    var codigo = document.getElementById('code_country');
    switch(o.value){
        case 'AF': codigo.value = "+93"; break;
        case 'ZA': codigo.value = "+27"; break;
        case 'AL': codigo.value = "+355"; break;
        case 'DE': codigo.value = "+49"; break;
        case 'AD': codigo.value = "+376"; break;
        case 'AO': codigo.value = "+244"; break;
        case 'AI': codigo.value = "+01"; break;
        case 'AG': codigo.value = "+01"; break;
        case 'SA': codigo.value = "+966"; break;
        case 'AR': codigo.value = "+54"; break;
        case 'AW': codigo.value = "+297"; break;
        case 'AU': codigo.value = "+61"; break;
        case 'AT': codigo.value = "+43"; break;
        case 'BS': codigo.value = "+01"; break;
        case 'BH': codigo.value = "+973"; break;
        case 'BB': codigo.value = "+01"; break;
        case 'BE': codigo.value = "+32"; break;
        case 'BZ': codigo.value = "+501"; break;
        case 'BM': codigo.value = "+01"; break;
        case 'BO': codigo.value = "+591"; break;
        case 'BW': codigo.value = "+267"; break;
        case 'BR': codigo.value = "+55"; break;
        case 'BN': codigo.value = "+673"; break;
        case 'BG': codigo.value = "+359"; break;        
        case 'BI': codigo.value = "+257"; break;
        case 'CV': codigo.value = "+238"; break;
        case 'KH': codigo.value = "+855"; break;
        case 'CA': codigo.value = "+01"; break;
        case 'TD': codigo.value = "+253"; break;
        case 'CL': codigo.value = "+56"; break;
        case 'CN': codigo.value = "+86"; break;
        case 'CO': codigo.value = "+57"; break;
        case 'DJ': codigo.value = "+253"; break;
        case 'DM': codigo.value = "+01"; break;
        case 'AE': codigo.value = "+971"; break;
        case 'EC': codigo.value = "+593"; break;
        case 'ES': codigo.value = "+34"; break;
        case 'US': codigo.value = "+01"; break;
        case 'FJ': codigo.value = "+679"; break;
        case 'PH': codigo.value = "+63"; break;
        case 'FI': codigo.value = "+358"; break;
        case 'FR': codigo.value = "+33"; break;
        case 'GA': codigo.value = "+241"; break;
        case 'GH': codigo.value = "+233"; break;
        case 'GI': codigo.value = "+350"; break;
        case 'GD': codigo.value = "+01"; break;
        case 'GR': codigo.value = "+30"; break;
        case 'GP': codigo.value = "+590"; break;
        case 'GU': codigo.value = "+671"; break;
        case 'GT': codigo.value = "+502"; break;
        case 'GY': codigo.value = "+592"; break;
        case 'GF': codigo.value = "+594"; break;
        case 'HT': codigo.value = "+501"; break;
        case 'NL': codigo.value = "+31"; break;
        case 'HN': codigo.value = "+504"; break;
        case 'HK': codigo.value = "+852"; break;
        case 'HU': codigo.value = "+36"; break;
        case 'CK': codigo.value = "+682"; break;
        case 'MH': codigo.value = "+692"; break;
        case 'IN': codigo.value = "+91"; break;
        case 'ID': codigo.value = "+62"; break;
        case 'EN': codigo.value = "+44"; break;
        case 'IR': codigo.value = "+98"; break;
        case 'IQ': codigo.value = "+964"; break;
        case 'IE': codigo.value = "+353"; break;
        case 'IS': codigo.value = "+354"; break;
        case 'IL': codigo.value = "+972"; break;
        case 'IT': codigo.value = "+39"; break;
        case 'JM': codigo.value = "+01"; break;
        case 'JP': codigo.value = "+81"; break;
        case 'KI': codigo.value = "+686"; break;
        case 'KW': codigo.value = "+965"; break;
        case 'LA': codigo.value = "+856"; break;
        case 'LS': codigo.value = "+266"; break;
        case 'LB': codigo.value = "+961"; break;
        case 'LY': codigo.value = "+218"; break;
        case 'LI': codigo.value = "+423"; break;
        case 'LU': codigo.value = "+352"; break;
        case 'MT': codigo.value = "+356"; break;
        case 'MA': codigo.value = "+212"; break;
        case 'MR': codigo.value = "+222"; break;
        case 'MU': codigo.value = "+230"; break;
        case 'MX': codigo.value = "+52"; break;
        case 'MZ': codigo.value = "+258"; break;
        case 'MC': codigo.value = "+377"; break;
        case 'MN': codigo.value = "+976"; break;
        case 'NA': codigo.value = "+264"; break;
        case 'NP': codigo.value = "+977"; break;
        case 'NI': codigo.value = "+505"; break;
        case 'NG': codigo.value = "+234"; break;
        case 'NO': codigo.value = "+47"; break;
        case 'NZ': codigo.value = "+64"; break;
        case 'OM': codigo.value = "+968"; break;
        case 'PA': codigo.value = "+507"; break;
        case 'PK': codigo.value = "+92"; break;
        case 'PY': codigo.value = "+595"; break;
        case 'PE': codigo.value = "+51"; break;
        case 'PF': codigo.value = "+689"; break;
        case 'PL': codigo.value = "+48"; break;
        case 'PT': codigo.value = "+351"; break;
        case 'QA': codigo.value = "+974"; break;
        case 'DO': codigo.value = "+01"; break;
        case 'RO': codigo.value = "+40"; break;
        case 'RU': codigo.value = "+07"; break;
        case 'SH': codigo.value = "+290"; break;
        case 'LC': codigo.value = "+01"; break;
        case 'VC': codigo.value = "+01"; break;
        case 'SY': codigo.value = "+963"; break;
        case 'SD': codigo.value = "+249"; break;
        case 'SE': codigo.value = "+46"; break;
        case 'CH': codigo.value = "+41"; break;
        case 'SR': codigo.value = "+597"; break;
        case 'TH': codigo.value = "+66"; break;
        case 'TW': codigo.value = "+886"; break;
        case 'TO': codigo.value = "+676"; break;
        case 'TT': codigo.value = "+01"; break;
        case 'TR': codigo.value = "+90"; break;
        case 'TV': codigo.value = "+688"; break;
        case 'UY': codigo.value = "+598"; break;
        case 'VU': codigo.value = "+678"; break;
        case 'ZM': codigo.value = "+260"; break;
        case 'ZW': codigo.value = "+263"; break;
    }
}

function altera_codigo(o){
    analisa_codigo_pais(o);
}
