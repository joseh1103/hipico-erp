/**
 * @param {String} colorStyle
 */
export const colorStyle = (data) => {
  switch (data) {
    case 'confirmed':
      return 'orange'
    case 'pending':
      return 'red'
    case 'delivered':
      return 'success'
    case 0:
      return 'orange'
    case 1:
      return 'success'
    default:
      return 'success'
  }
}
/*
autor : Jose Hernandez
method: format price
*/


/*
* función que calcula los montos
 
function calcula() {
 //console.log('calcula');
 var d = $("#subtotal").val();
 d = d.replace(/(,|\$|\s)/g,'');
 //console.log(d);
 var sub=parseFloat(d);
 if(sub<0 || isNaN(sub))sub=0;
 if(sub==0) {
       return false;
 }
 var d4 = document.getElementById("d4").checked
 var separa = document.getElementById("separa").checked
 var dec = 2;
 if(d4) { dec=4; }
 var estotal = document.getElementById("estotal").checked;
 var $subtotal=0;
 var per = $("input[name='persona']").prop('checked');
 //elige como total? si es persona moral, desaperece.
 if(!per) { estotal = document.getElementById("estotal").checked = false; $("#estotale").hide(); }
 else { $("#estotale").show(); }
 if(estotal && per) {
       $subtotal = sub/0.95333333;
       sub=$subtotal;
       subtotale = sub;
    } else {
       $subtotal = sub;
 }
 var xiva = $(".xiva:checked").val();
 //var $iva=sub*.16;
 var $iva = (sub * xiva) / 100; //calcula el IVA
 console.log("iva = (sub) "+sub+' , '+$iva);
 // persona física o moral
 if(per) {
       var $isr = sub*.1;
       var $riva = ($iva/3)*2;
       var $total= (sub+$iva) - $isr - $riva;
    } else {
       var $isr = 0;
       var $riva = 0;
       var $total= (sub+$iva) - $isr - $riva;
 }
 //
 if(isNaN($isr))$isr=0;
 if(isNaN($iva))$iva=0;
 if(isNaN($riva))$riva=0;
 if(isNaN($total<0))$total=0;
 //
 // muestra los montos en la tabla de resultados
 $(".rsubtotal").html('$'+ number_format(sub,dec,separa));
 $(".riva").html('$'+ number_format($iva,dec,separa));
 $(".rriva").html('$'+ number_format($riva,dec,separa));
 $(".risr").html('$'+ number_format($isr,dec,separa));
 var $elsub = sub+$iva;
 $(".elsubtotal").html('$'+  number_format($elsub,dec,separa));
 //
 //
 $(".total").html('$'+ number_format($total,dec,separa));
 //
 $(".retiene1").html('IVA '+xiva+'% (+) <small class="text-muted">tasa '+(xiva/100)+' </small>');
 //
 var $enum = 'De una factura de honorarios que usted emita por <strong class="text-info">$'+number_format(sub,dec,separa)+'</strong> +IVA ('+xiva+'%), ';
 $enum += ' el cálculo arrojará un';
 $enum += ' IVA a trasladar por <strong class="text-warning">$'+number_format($iva,dec,separa)+"</strong>";
 if(per) {
    $enum += ', de retención de IVA <strong class="text-success">$'+number_format($riva,dec,separa);
       $enum += '</strong> de retención de ISR <strong class="text-success">$'+number_format($isr,dec,separa)+'</strong>';
 }
 $enum += '. Usted recibirá un total de <strong class="text-danger">$'+number_format($total,dec,separa);
    $enum += '</strong> pesos M/N y la factura saldrá por un total de <strong>$';
    $enum += number_format($elsub,dec,separa)+ '</strong> (subtotal + IVA)';
 $("#resultado").html($enum);
}
$("#envia").on( "click", function(event) {
var data = "RESULTADO: ";
data += $("#resultando").text();
data += "\r\n\r\n";
data += $("#resultado").text();
data += "\r\n\r\n -- Cálculo de honorarios https://tar.mx/apps/honorarios/\r\n";
$(this).attr('href',"mailto:?subject=resultado honorarios "+$(".rsubtotal").html()+" +IVA&body="+encodeURIComponent(data));
});


//https://gist.github.com/jrobinsonc/5718959
var number_format = function(amount, decimals,separa) {
 if(!separa) { return amount.toFixed(decimals); }
 amount += ''; // por si pasan un numero en vez de un string
 amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto
 decimals = decimals || 0; // por si la variable no fue fue pasada
 // si no es un numero o es igual a cero retorno el mismo cero
 if (isNaN(amount) || amount === 0) 
 return parseFloat(0).toFixed(decimals);
 // si es mayor o menor que cero retorno el valor formateado como numero
 amount = '' + amount.toFixed(decimals);
 var amount_parts = amount.split('.'),
 regexp = /(\d+)(\d{3})/;
 while (regexp.test(amount_parts[0]))
 amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');
 return amount_parts.join('.');
}
*/


export const numberFormat = (amount, decimalCount = 2, decimal = ".", thousands = ",") => {
  try {
    decimalCount = Math.abs(decimalCount);
    decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

    // const negativeSign = amount < 0 ? "-" : "";

    let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
    let j = (i.length > 3) ? i.length % 3 : 0;

    return (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
  } catch (e) {
    console.log(e)
  }
}
export const banck = [
  {
    "code": "0001",
    "name": "Banco Central de Venezuela",
    "rif": "G200001100"
},
{
    "code": "0102",
    "name": "Banco de Venezuela S.A.C.A. Banco Universal",
    "rif": "G200099976"
},
{
    "code": "0104",
    "name": "Venezolano de Crédito, S.A. Banco Universal",
    "rif": "J000029709"
},
{
    "code": "0105",
    "name": "Banco Mercantil, C.A. Banco Universal",
    "rif": "J000029610"
},
{
    "code": "0108",
    "name": "Banco Provincial, S.A. Banco Universal",
    "rif": "J000029679"
},
{
    "code": "0114",
    "name": "Bancaribe C.A. Banco Universal",
    "rif": "J000029490"
},
{
    "code": "0115",
    "name": "Banco Exterior C.A. Banco Universal",
    "rif": "J000029504"
},
{
    "code": "0116",
    "name": "Banco Occidental de Descuento, Banco Universal C.A",
    "rif": "J300619460"
},
{
    "code": "0128",
    "name": "Banco Caroní C.A. Banco Universal",
    "rif": "J095048551"
},
{
    "code": "0134",
    "name": "Banesco Banco Universal S.A.C.A.",
    "rif": "J070133805"
},
{
    "code": "0137",
    "name": "Banco Sofitasa, Banco Universal",
    "rif": "J090283846"
},
{
    "code": "0138",
    "name": "Banco Plaza, Banco Universal",
    "rif": "J002970553"
},
{
    "code": "0146",
    "name": "Banco de la Gente Emprendedora C.A",
    "rif": "J301442040"
},
{
    "code": "0151",
    "name": "BFC Banco Fondo Común C.A. Banco Universal",
    "rif": "J000723060"
},
{
    "code": "0156",
    "name": "100% Banco, Banco Universal C.A.",
    "rif": "J085007768"
},
{
    "code": "0157",
    "name": "DelSur Banco Universal C.A.",
    "rif": "J000797234"
},
{
    "code": "0163",
    "name": "Banco del Tesoro, C.A. Banco Universal",
    "rif": "G200051876"
},
{
    "code": "0166",
    "name": "Banco Agrícola de Venezuela, C.A. Banco Universal",
    "rif": "G200057955"
},
{
    "code": "0168",
    "name": "Bancrecer, S.A. Banco Microfinanciero",
    "rif": "J316374173"
},
{
    "code": "0169",
    "name": "Mi Banco, Banco Microfinanciero C.A.",
    "rif": "J315941023"
},
{
    "code": "0171",
    "name": "Banco Activo, Banco Universal",
    "rif": "J080066227"
},
{
    "code": "0172",
    "name": "Bancamica, Banco Microfinanciero C.A.",
    "rif": "J316287599"
},
{
    "code": "0173",
    "name": "Banco Internacional de Desarrollo, C.A. Banco Universal",
    "rif": "J294640109"
},
{
    "code": "0174",
    "name": "Banplus Banco Universal, C.A",
    "rif": "J000423032"
},
{
    "code": "0175",
    "name": "Banco Bicentenario del Pueblo de la Clase Obrera, Mujer y Comunas B.U.",
    "rif": "G200091487"
},
{
    "code": "0176",
    "name": "Novo Banco, S.A. Sucursal Venezuela Banco Universal",
    "rif": "J308918644"
},
{
    "code": "0177",
    "name": "Banco de la Fuerza Armada Nacional Bolivariana, B.U.",
    "rif": "G200106573"
},
{
    "code": "0190",
    "name": "Citibank N.A.",
    "rif": "J000526621"
},
{
    "code": "0191",
    "name": "Banco Nacional de Crédito, C.A. Banco Universal",
    "rif": "J309841327"
},
{
    "code": "0601",
    "name": "Instituto Municipal de Crédito Popular",
    "rif": "G200068973"
}
]
/*
export const banck = [
    {
      value: '0156',
      text: '100%BANCO'
    },
    {
      value: '0196',
      text: 'ABN-AMRO-BANK'
    },
    {
      value: '0172',
      text: 'BANCAMIGA-BANCO-MICROFINANCIERO'
    },
    {
      value: '0171',
      text: 'BANCO-ACTIVO-BANCO-COMERCIAL'
    },
    {
      value: '0166',
      text: 'BANCO-AGRICOLA'
    },
    {
      value: '0175',
      text: 'BANCO-BICENTENARIO'
    },
    {
      value: '0128',
      text: 'BANCO-CARONI-BANCO-UNIVERSAL'
    },
    {
      value: '0164',
      text: 'BANCO-DE-DESARROLLO-DEL-MICROEMPRESARIO'
    },
    {
      value: '0102',
      text: 'BANCO-DE-VENEZUELA'
    },
    {
      value: '0114',
      text: 'BANCO-DEL-CARIBE'
    },
    {
      value: '0149',
      text: 'BANCO-DEL-PUEBLO-SOBERANO'
    },
    {
      value: '0163',
      text: 'BANCO-DEL-TESORO'
    },
    {
      value: '0176',
      text: 'BANCO-ESPIRITO-SANTO'
    },
    {
      value: '0115',
      text: 'BANCO-EXTERIOR'
    },
    {
      value: '0003',
      text: 'BANCO-INDUSTRIAL-DE-VENEZUELA'
    },
    {
      value: '0173',
      text: 'BANCO-INTERNACIONAL-DE-DESARROLLO'
    },
    {
      value: '0105',
      text: 'BANCO-MERCANTIL'
    },
    {
      value: '0191',
      text: 'BANCO-NACIONAL-DE-CREDITO'
    },
    {
      value: '0116',
      text: 'BANCO-OCCIDENTAL-DE-DESCUENTO'
    },
    {
      value: '0138',
      text: 'BANCO-PLAZA'
    },
    {
      value: '0108',
      text: 'BANCO-PROVINCIAL-BBVA'
    },
    {
      value: '0104',
      text: 'BANCO-VENEZOLANO-DE-CREDITO'
    },
    {
      value: '0168',
      text: 'BANCRECER-BANCO-DE-DESARROLLO'
    },
    {
      value: '0134',
      text: 'BANESCO-BANCO-UNIVERSAL'
    },
    {
      value: '0177',
      text: 'BANFANB'
    },
    {
      value: '0146',
      text: 'BANGENTE'
    },
    {
      value: '0174',
      text: 'BANPLUS-BANCO-COMERCIAL'
    },
    {
      value: '0190',
      text: 'CITIBANK'
    },
    {
      value: '0121',
      text: 'CORP-BANCA'
    },
    {
      value: '0157',
      text: 'DELSUR-BANCO-UNIVERSAL'
    },
    {
      value: '0151',
      text: 'FONDO-COMUN'
    },
    {
      value: '0601',
      text: 'INSTITUTO-MUNICIPAL-DE-CREDITO-POPULAR'
    },
    {
      value: '0169',
      text: 'MIBANCO-BANCO-DE-DESARROLLO'
    },
    {
      value: '0137',
      text: 'SOFITASA'
    }
]*/

export const ramos = [
  {
    value: '1',
    text: 'Carniceria',
  },
  {
    value: '2',
    text: 'Charcuteria'
  },
  {
    value: '3',
    text: 'Panaderia'
  },
  {
    value: '4',
    text: 'Farmacia'
  }
]


export const currency = [
  {
    value: '$',
    text: 'Dolar USD',
  },
  {
    value: '€',
    text: 'EURO'
  },
  {
    value: 'Bs',
    text: 'Bolivares'
  },
]

export const menuModules = [
  {
    name: 'Dashboard',
    path: '/',
    icon: 'dashboard',
    hideInMenu: true,
    key: 'dashboard',
    className: 'bold'
  },
  {
    name: 'users',
    path: '/admin/user',
    icon: 'user',
    hideInMenu: true,
    key: 'user-admin',
    className: 'bold',
    children: [
      {
        name: 'view',
        key: 'user-view'
      },
      {
        name: 'create',
        key: 'user-create'
      },
      {
        name: 'edit',
        key: 'user-edit'
      },
      {
        name: 'delete',
        key: 'user-delete'
      }
    ]
  }
]
