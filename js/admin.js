let admin = new Vue({
    el: '.tabs',
    data: {
        fs: false,
        ss: false,
        lessons: [],
        receps: [],
        povars: [],
        recepsSettings: {
            error: "",
            success: ""
        },
        lessonsSettings: {
            error: "",
            success: ""
        }
    },
    created: function() {
        fetch('/php/get.php?table=povars').then(r => {return r.json()}).then(pvs => {
            for (let pv of pvs) {
                admin.povars.push(pv)
            }
        })
        fetch('/php/get.php?table=receps').then(r => {return r.json()}).then(pvs => {
            for (let pv of pvs) {
                admin.receps.push(pv)
            }
        })
        fetch('/php/get.php?table=lessons').then(r => {return r.json()}).then(pvs => {
            for (let pv of pvs) {
                admin.lessons.push(pv)
            }
        })
    },
    methods: {
        saveRecept(ev) {
            ev.preventDefault();
            form = ev.target.parentElement.parentElement;
            let fd = new FormData(form);
            let saveFD = new FormData();
            let sql = `UPDATE \`receps\` SET \`name\` = '${fd.get('name')}', \`desc\` = '${fd.get('desc')}',
             \`lesson_id\` = '${fd.get('lesson_id')}', \`ingridents\` = '${fd.get('ingridents')}', 
             \`makelist\` = '${fd.get('makelist')}' WHERE \`receps\`.\`id\` = ${fd.get('id')}`;
            saveFD.append('sql', sql);
            fetch('/php/save.php', {
                method: "POST",
                body: saveFD
            }).then(r => r.json()).then(d => {
                if (d.status == 200) {
                    admin.receps.forEach(el => {
                        if (el.id == fd.get('id')) { 
                            el.name = fd.get('name');
                            el.desc = fd.get('decs');
                            el.makelist = fd.get('makelist');
                            el.lesson_id = fd.get('lesson_id');
                            el.ingridents = fd.get('ingridents');
                        } 
                    })
                }
                console.log(d)
            })
            
        },
        savePovar(ev) {
            ev.preventDefault();
            form = ev.target.parentElement.parentElement;
            let fd = new FormData(form);
            let saveFD = new FormData();
            let sql = `UPDATE \`povars\` SET \`fio\` = '${fd.get('fio')}' WHERE \`povars\`.\`id\` = ${fd.get('id')}`;
            saveFD.append('sql', sql);
            fetch('/php/save.php', {
                method: "POST",
                body: saveFD
            }).then(r => r.json()).then(d => {
                if (d.status == 200) {
                    admin.povars.forEach(el => {
                        if (el.id == fd.get('id')) { 
                            el.fio = fd.get('fio');
                        } 
                    })
                }
                console.log(d)
            })
            
        },
        saveLesson(ev) {
            ev.preventDefault();
            form = ev.target.parentElement.parentElement;
            let fd = new FormData(form);
            let saveFD = new FormData();
            let sql = `UPDATE \`lessons\` SET \`name\` = '${fd.get('name')}',
            \`date\` = '${fd.get('date')}', \`time\` = '${fd.get('time')}', \`audit\` = '${fd.get('audit')}', \`povar\` = '${fd.get('povar')}'  WHERE \`lessons\`.\`id\` = ${fd.get('id')}`;
            saveFD.append('sql', sql);
            fetch('/php/save.php', {
                method: "POST",
                body: saveFD
            }).then(r => r.json()).then(d => {
                if (d.status == 200) {
                    admin.lessons.forEach(el => {
                        if (el.id == fd.get('id')) { 
                            el.name = fd.get('name');
                            el.date = fd.get('date');
                            el.time = fd.get('time');
                            el.audit = fd.get('audit');
                            el.povar = fd.get('povar');
                        } 
                    })
                }
                console.log(d)
            })
            
        },
        removeRecept(ev) {
            let id = ev.target.dataset.id;
            fetch('/php/remove.php?table=receps&id=' + id).then(r => r.json())
            .then(r => {
                if (r.status == 200) {
                    admin.receps.forEach(el => {
                        if (el.id == id) { 
                        let index = admin.receps.indexOf(el); 
                        admin.receps.splice(index, 1); 
                        } 
                    })
                }
                console.log(r);
            })
        },
        removeLesson(ev) {
            let id = ev.target.dataset.id;
            fetch('/php/remove.php?table=lessons&id=' + id).then(r => r.json())
            .then(r => {
                if (r.status == 200) {
                    admin.lessons.forEach(el => {
                        if (el.id == id) { 
                        let index = admin.lessons.indexOf(el); 
                        admin.lessons.splice(index, 1); 
                        } 
                    })
                }
                console.log(r);
            })
        },
        removePovar(ev) {
            let id = ev.target.dataset.id;
            fetch('/php/remove.php?table=povars&id=' + id).then(r => r.json())
            .then(r => {
                if (r.status == 200) {
                    admin.povars.forEach(el => {
                        if (el.id == id) { 
                        let index = admin.povars.indexOf(el); 
                        admin.povars.splice(index, 1); 
                        } 
                    })
                }
                console.log(r);
            })
        },
        createRecept() {
            this.error = ""
            this.msg = ""
            let fd = new FormData(document.forms[0])
            for (el of fd.entries()) {
                if (el[0] != 'video_src' && el[0] != 'img_src' && el[0] != 'lesson_id' && el[1] == "") {
                    createTab.error = "Заполните все поля";
                    return false;
                }
            }
            let options = {
                method: 'POST',
                body: fd,
                headers: {
                    // 'Content-Type': 'multipart/form-data'
                }
            }
            fetch('/php/insert.php', options).then( r => {return r.json()})
            .then(data => {
                if (data.status == 201) {
                    admin.recepsSettings.success = "Успешно";
                    console.log(data)
                    admin.receps.push(data.r);
                    document.forms[0].reset();
                } else {
                    console.log(data.reason);
                    admin.recepsSettings.error = "Возникла ошибка, повторите еще раз";
                }
            });
        },
        createLesson(ev) {
            admin.lessonsSettings.error = ""
            admin.lessonsSettings.success = ""
            let fd = new FormData(admin.$refs.createLessonForm)
            fd.append('table', 'lessons')
            for (el of fd.entries()) {
                if (el[1] == "") {
                    createTab.error = "Заполните все поля";
                    return false;
                }
            }
            fetch('/php/insertPv.php', {
                method: 'POST',
                body: fd,
            }).then( r => {return r.json()})
            .then(data => {
                if (data.status == 201) {
                    admin.lessonsSettings.success = "Успешно";
                    console.log(data)
                    admin.lessons.push(data.r);
                    admin.$refs.createLessonForm.reset();
                } else {
                    console.log(data.reason);
                    admin.lessonsSettings.error = "Возникла ошибка, повторите еще раз";
                }
            });
        },
        createPovar(ev) {
            let form = ev.target.previousElementSibling.previousElementSibling.previousElementSibling;
            let fd = new FormData(form)
            fd.append('table', 'povars')
            fetch('/php/insertPv.php', {
                method: 'POST',
                body: fd,
            }).then( r => {return r.json()})
            .then(data => {
                if (data.status == 201) {
                    console.log(data)
                    admin.povars.push(data.r);
                    form.reset();
                } else {
                    console.log(data.reason);
                }
            });
        },
        showF(el) {
            for (let div of document.querySelectorAll('.recep .row:nth-child(2)')) {
                div.style.display = 'none';
            }
            for (let div of document.querySelectorAll('.recep form')) {
                div.style.display = 'none';
            }
            el.target.parentElement.parentElement.querySelector('.row:nth-child(2)').style.display = 'grid'; 
        }, 
        showS(el) {
            for (let div of document.querySelectorAll('.recep form')) {
                div.style.display = 'none';
            }
            for (let div of document.querySelectorAll('.recep .row:nth-child(2)')) {
                div.style.display = 'none';
            }
            el.target.parentElement.parentElement.parentElement.querySelector('form').style.display = 'grid'; 
        },
        showFormPovar(el) {
            for (let div of document.querySelectorAll('.povar form')) {
                div.style.display = 'none';
            }
            el.target.parentElement.parentElement.parentElement.querySelector('form').style.display = 'grid'; 
        }
    }
})
