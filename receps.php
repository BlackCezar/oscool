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
    <div class="user">
        <div class="likes" v-show="false" ref="userLikes"><?php 
        $pdo = new PDO('mysql:host=kraycenter.ru;dbname=a0274741_psih;charset=utf8', 'a0274741', 'wuecpesica');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $id = $_SESSION['user']['id'];
        $s = $pdo->query("SELECT * FROM users WHERE id = $id");
        $s = $s->fetch();
        print($s['receps']);
        ?></div>
    </div>
    <h2>Избранные рецепты:</h2>
    <div class="receps">
        <div class="recep" v-for="recept of likes">
            <div class="row1" style="grid-template-rows: unset;grid-template-columns: 40% 40% 20%">
                <div class="nu" style="display: flex; justify-content: center;"><img v-if="recept.img_src" :src="recept.img_src" width="90%"></div>
                <div class="title" @click="showF($event)">{{ recept.name }}</div>
                <div class="btns" style="display: flex; justify-content: flex-end">
                    <i class="fas fa-heart" :data-id="recept.id" @click="removeRecept($event)"></i>
                    <i class="fas fa-print" :data-id="recept.id" style="display: block; margin-left: 1vw" @click="printEl($event)"></i>
                </div>
            </div>
            <div class="row">
                <div class="desc">
                    <span class="desc">Описание:</span>
                    <div class="desc">
                        {{ recept.desc }}
                    </div>
                </div>
                <div class="ingridients">
                    <span class="ingr">Ингридиенты:</span>
                    <div class="ingr">
                        {{ recept.ingridents }}
                    </div>
                </div>
                <div class="makelist">
                    <span class="makelist">Способ приготовления:</span>
                    <div class="makelist">
                        {{ recept.makelist }}
                    </div>
                </div>
                <div class="lesson">
                    <span class="lesson">Привязанный урок:</span>
                    <div class="lesson">
                        <template v-for="lesson of lessons" v-if="lesson.id == recept.lesson_id">
                            {{ lesson.name }}
                        </template>
                    </div>
                </div>
                <div class="img">
                    <span class="img">Изображение:</span>
                    <img v-if="recept.img_src" class="admin_img" :src="recept.img_src" alt=""><span v-if="!recept.img_src">Нет изображения</span>
                </div>
                <div class="video">
                    <span class="video">Видео:</span>
                    <video v-if="recept.video_src" controls="controls" :src="recept.video_src"></video><span v-if="!recept.video_src">Нет видео</span>
                </div>
            </div>
        </div>
    </div>
    <h2>Рецепты:</h2>
    <div class="receps">
        <div class="recep" v-for="recept of receps">
            <div class="row1" style="grid-template-rows: unset;grid-template-columns: 40% 40% 20%">
                <div class="nu" style="display: flex; justify-content: center;"><img v-if="recept.img_src" :src="recept.img_src" width="90%"></div>
                <div class="title" @click="showF($event)">{{ recept.name }}</div>
                <div class="btns" style="display: flex; justify-content: flex-end">
                    <i class="far fa-heart" :data-id="recept.id" @click="selectIt($event)"></i>
                    <i class="fas fa-print" :data-id="recept.id" style="display: block; margin-left: 1vw" @click="printEl($event)"></i>
                </div>
            </div>
            <div class="row">
                <div class="desc">
                    <span class="desc">Описание:</span>
                    <div class="desc">
                        {{ recept.desc }}
                    </div>
                </div>
                <div class="ingridients">
                    <span class="ingr">Ингридиенты:</span>
                    <div class="ingr">
                        {{ recept.ingridents }}
                    </div>
                </div>
                <div class="makelist">
                    <span class="makelist">Способ приготовления:</span>
                    <div class="makelist">
                        {{ recept.makelist }}
                    </div>
                </div>
                <div class="lesson">
                    <span class="lesson">Привязанный урок:</span>
                    <div class="lesson">
                        <template v-for="lesson of lessons" v-if="lesson.id == recept.lesson_id">
                            {{ lesson.name }}
                        </template>
                    </div>
                </div>
                <div class="img">
                    <span class="img">Изображение:</span>
                    <img v-if="recept.img_src" class="admin_img" :src="recept.img_src" alt=""><span v-if="!recept.img_src">Нет изображения</span>
                </div>
                <div class="video">
                    <span class="video">Видео:</span>
                    <video v-if="recept.video_src" controls="controls" :src="recept.video_src"></video><span v-if="!recept.video_src">Нет видео</span>
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
        receps: [],
        likes: [],
    },
    created: function() {
        fetch('/php/get.php?table=receps').then(r => {return r.json()}).then(pvs => {
            setTimeout(() => {
                let eels = []
                if (document.querySelector('.likes')) {
                    eels = document.querySelector('.likes').innerText.split(', ');
                }
                for (let pv of pvs) {
                    admin.receps.push(pv);
                    for (ul of eels) {
                        if (ul == pv.id) admin.likes.push(pv);
                    }
                }
            }, 1);
            
        })
        fetch('/php/get.php?table=lessons').then(r => {return r.json()}).then(pvs => {
            for (let pv of pvs) {
                admin.lessons.push(pv)
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
                let id = ev.target.dataset.id;
                if (el.id == id) {
                    admin.likes.push(el);
                    let fd = new FormData();
                    let s = "";
                    if (document.querySelector('.likes').innerText != "") s = document.querySelector('.likes').innerText + ', '; 
                    fd.append('sql', `UPDATE \`users\` SET \`receps\` = '${  s + id}' WHERE id = <?php print($_SESSION['user']['id']) ?> `);
                    fetch('/php/save.php', {
                        method: 'POST',
                        body: fd
                    }).then(r => r.json()).then(r => console.log(r));
                }
            }
        },
        removeRecept(ev) {
            ev.target.parentElement.parentElement.parentElement.remove();
        }
    }
})

</script>

<?php include('footer.php'); ?>