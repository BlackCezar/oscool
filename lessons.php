<?php include('header.php'); 
if ($_SESSION['auth'] != true) {
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'index.php';
	header("Location: http://$host$uri/$extra");
	exit;
}
?>
<link rel="stylesheet" href="css/admin.css">

<div class="con">
    <h2>Уроки:</h2>
    <div class="receps">
        <div class="recep" v-for="recept of lessons">
            <div class="row1" style="grid-template-rows: unset;grid-template-columns: 30% 50% 20%">
                <div class="nu" style="">{{ recept.date }}</div>
                <div class="title" @click="showF($event)">{{ recept.name }}</div>
                <div class="btns" style="display: flex; justify-content: flex-end">
                </div>
            </div>
            <div class="row">
                <div class="desc">
                    <span class="desc">Дата и время:</span>
                    <div class="desc">
                        {{ recept.date }} {{ recept.time }}
                    </div>
                </div>
                <div class="ingridients">
                    <span class="ingr">Повар:</span>
                    <div class="ingr">
                        <template v-for="pv of povars" v-if="recept.povar == pv.id">
                            {{ pv.fio }}
                        </template>
                    </div>
                </div>
                <div class="desc">
                    <span class="desc">Кабинет:</span>
                    <div class="desc">
                        {{ recept.audit }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
<script src="js/vue.js"></script>
<script>
let admin = new Vue({
    el: '.con',
    data: {
        lessons: [],
        povars: [],
    },
    created: function() {
        fetch('/php/get.php?table=lessons').then(r => {return r.json()}).then(pvs => {
            for (let pv of pvs) {
                admin.lessons.push(pv);
            }
        })
        fetch('/php/get.php?table=povars').then(r => {return r.json()}).then(pvs => {
            for (let pv of pvs) {
                admin.povars.push(pv)
            }
        })

        
    },
    mounted: function() {
    },
    methods: {
        showF(el) {
            for (let div of document.querySelectorAll('.recep .row:nth-child(2)')) {
                div.style.display = 'none';
            }
            el.target.parentElement.parentElement.querySelector('.row:nth-child(2)').style.display = 'grid'; 
        }, 
        printEl(el) {
            var prtContent = el.target.parentElement.parentElement.nextElementSibling;
            var prtCSS = '<link rel="stylesheet" href="/css/style.css" type="text/css" /><link rel="stylesheet" href="/css/admin.css" type="text/css" />';
            var WinPrint = window.open('','','left=50,top=50,width=800,height=640,toolbar=0,scrollbars=1,status=0');
            WinPrint.document.write('<div id="print" class="receps">');
            WinPrint.document.write(prtCSS);
            WinPrint.document.write(prtContent.innerHTML);
            WinPrint.document.write('</div>');
            WinPrint.document.close();
            WinPrint.focus();
            WinPrint.print();
            WinPrint.close();
        },
        selectIt(ev) {
            for (el of admin.receps) {
                if (el.id == ev.target.dataset.id) {
                    admin.likes.push(el);
                }
            }
        }
    }
})

</script>

<?php include('footer.php'); ?>