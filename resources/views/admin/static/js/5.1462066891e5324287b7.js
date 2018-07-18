webpackJsonp([5],{"1cNm":function(e,a){},MSFi:function(e,a){},"dD/V":function(e,a){},nI3X:function(e,a,t){"use strict";Object.defineProperty(a,"__esModule",{value:!0});var l={name:"addDialog",props:{addOpen:{type:Boolean,default:!1}},data:function(){return{state2:this.addOpen,activeName:"first",addForm:{account:"",password:"123456",role_id:"",head:"",group_id:"",department_id:"",sex:0,phone:"",mphone:"",area_province:"",area_city:"",area_district:"",realname:"",address:"",qq:"",qq_nickname:"",weixin:"",weixin_nikname:"",id_card:"",card_img:"",card_front:"",card_back:""}}},methods:{handleClose:function(){this.$emit("add-window-close")},addFormSubmit:function(){console.log(this.addForm)},closeDialog:function(){this.state2=!1}},watch:{addOpen:function(e,a){this.state2=e}}},o={render:function(){var e=this,a=e.$createElement,t=e._self._c||a;return t("div",[t("el-dialog",{attrs:{title:"添加员工",visible:e.state2},on:{"update:visible":function(a){e.state2=a},close:e.handleClose}},[t("el-form",{ref:"addForm",attrs:{model:e.addForm,inline:!0}},[t("el-tabs",{attrs:{type:"card"},model:{value:e.activeName,callback:function(a){e.activeName=a},expression:"activeName"}},[t("el-tab-pane",{attrs:{label:"账号",name:"first"}},[t("el-row",[t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"登录账号",prop:"account"}},[t("el-input",{attrs:{"auto-complete":"off"},model:{value:e.addForm.account,callback:function(a){e.$set(e.addForm,"account",a)},expression:"addForm.account"}})],1),e._v(" "),t("el-form-item",{attrs:{label:"密码"}},[t("el-input",{attrs:{"auto-complete":"off"},model:{value:e.addForm.password,callback:function(a){e.$set(e.addForm,"password",a)},expression:"addForm.password"}})],1)],1),e._v(" "),t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"员工姓名",prop:"realname"}},[t("el-input",{attrs:{"auto-complete":"off"},model:{value:e.addForm.realname,callback:function(a){e.$set(e.addForm,"realname",a)},expression:"addForm.realname"}})],1),e._v(" "),t("el-form-item",{attrs:{label:"员工职能"}},[t("el-select",{model:{value:e.addForm.role_id,callback:function(a){e.$set(e.addForm,"role_id",a)},expression:"addForm.role_id"}},[t("el-option",{attrs:{label:"普通员工",value:"1"}}),e._v(" "),t("el-option",{attrs:{label:"精英员工",value:"2"}})],1)],1)],1)],1),e._v(" "),t("el-row",[t("el-col",[t("el-form-item",{attrs:{label:"所属部门",prop:"department_id"}},[t("el-select",{model:{value:e.addForm.department_id,callback:function(a){e.$set(e.addForm,"department_id",a)},expression:"addForm.department_id"}},[t("el-option",{attrs:{label:"推广部",value:"4"}}),e._v(" "),t("el-option",{attrs:{label:"销售部",value:"0"}})],1)],1)],1)],1)],1),e._v(" "),t("el-tab-pane",{attrs:{label:"其它信息",name:"second"}},[t("el-row",[t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"头像"}},[t("img",{directives:[{name:"show",rawName:"v-show",value:e.addUploadImg,expression:"addUploadImg"}],staticStyle:{"max-width":"200px","max-height":"200px"},attrs:{src:e.addUpload,alt:""}}),e._v(" "),t("el-upload",{attrs:{action:"{:U('Upload/index2')}",accept:"image/jpeg,image/png,image/jpg,image/gif,image/bmp","on-success":e.addFormUploadSuccess,"on-error":e.addFormUploadError,data:e.pathInfo,headers:e.xuploadheader,multiple:!1,"show-upload-list":!1}},[t("el-button",{attrs:{size:"small",type:"primary"}},[e._v("点击上传")])],1)],1)],1)],1),e._v(" "),t("el-row",[t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"性别"}},[t("el-radio",{staticClass:"radio",attrs:{label:"1"},model:{value:e.addForm.sex,callback:function(a){e.$set(e.addForm,"sex",a)},expression:"addForm.sex"}},[e._v("男")]),e._v(" "),t("el-radio",{staticClass:"radio",attrs:{label:"2"},model:{value:e.addForm.sex,callback:function(a){e.$set(e.addForm,"sex",a)},expression:"addForm.sex"}},[e._v("女")])],1)],1)],1),e._v(" "),t("el-row",[t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"手机",prop:"mphone"}},[t("el-input",{attrs:{"auto-complete":"off"},model:{value:e.addForm.mphone,callback:function(a){e.$set(e.addForm,"mphone",a)},expression:"addForm.mphone"}})],1)],1),e._v(" "),t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"固话座机",prop:"phone"}},[t("el-input",{attrs:{"auto-complet":"off"},model:{value:e.addForm.phone,callback:function(a){e.$set(e.addForm,"phone",a)},expression:"addForm.phone"}})],1)],1)],1),e._v(" "),t("el-row",[t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"QQ号",prop:"qq"}},[t("el-input",{attrs:{"auto-complete":"off"},model:{value:e.addForm.qq,callback:function(a){e.$set(e.addForm,"qq",a)},expression:"addForm.qq"}})],1)],1),e._v(" "),t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"QQ昵称"}},[t("el-input",{attrs:{"auto-complet":"off"},model:{value:e.addForm.qq_nickname,callback:function(a){e.$set(e.addForm,"qq_nickname",a)},expression:"addForm.qq_nickname"}})],1)],1)],1),e._v(" "),t("el-row",[t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"微信号",prop:"weixin"}},[t("el-input",{attrs:{"auto-complete":"off"},model:{value:e.addForm.weixin,callback:function(a){e.$set(e.addForm,"weixin",a)},expression:"addForm.weixin"}})],1)],1),e._v(" "),t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"微信昵称"}},[t("el-input",{attrs:{"auto-complet":"off"},model:{value:e.addForm.weixin_nikname,callback:function(a){e.$set(e.addForm,"weixin_nikname",a)},expression:"addForm.weixin_nikname"}})],1)],1)],1),e._v(" "),t("el-row",[t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"身份证号",prop:"id_card"}},[t("el-input",{attrs:{"auto-complet":"off"},model:{value:e.addForm.id_card,callback:function(a){e.$set(e.addForm,"id_card",a)},expression:"addForm.id_card"}})],1)],1)],1),e._v(" "),t("el-row",[t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"省份"}},[t("el-select",{attrs:{placeholder:"请选择"},model:{value:e.addForm.area_province,callback:function(a){e.$set(e.addForm,"area_province",a)},expression:"addForm.area_province"}},[t("el-option",{attrs:{label:"北京",value:"1"}}),e._v(" "),t("el-option",{attrs:{label:"上海",value:"2"}})],1)],1)],1),e._v(" "),t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"城市"}},[t("el-select",{attrs:{placeholder:"请选择"},model:{value:e.addForm.area_city,callback:function(a){e.$set(e.addForm,"area_city",a)},expression:"addForm.area_city"}},[t("el-option",{attrs:{label:"北京",value:"1"}}),e._v(" "),t("el-option",{attrs:{label:"上海",value:"2"}})],1)],1)],1)],1),e._v(" "),t("el-row",[t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"区县"}},[t("el-select",{attrs:{placeholder:"请选择"},model:{value:e.addForm.area_district,callback:function(a){e.$set(e.addForm,"area_district",a)},expression:"addForm.area_district"}},[t("el-option",{attrs:{label:"北京",value:"1"}}),e._v(" "),t("el-option",{attrs:{label:"上海",value:"2"}})],1)],1)],1)],1),e._v(" "),t("el-form-item",{attrs:{label:"住址"}},[t("el-input",{attrs:{type:"textarea",autosize:{minRows:2,maxRows:4},placeholder:"请输入内容"},model:{value:e.addForm.address,callback:function(a){e.$set(e.addForm,"address",a)},expression:"addForm.address"}})],1)],1),e._v(" "),t("el-tab-pane",{staticClass:"third",attrs:{label:"身份证照",name:"third"}},[t("el-row",[t("el-col",{attrs:{span:24}},[t("el-form-item",{attrs:{label:"手持身份证照"}},[t("el-upload",{staticClass:"card_img",attrs:{action:"{:U('Upload/index2')}",accept:"image/jpeg,image/png,image/jpg,image/gif,image/bmp","on-success":e.cardImg,data:e.pathInfo,headers:e.xuploadheader,multiple:!1,"show-upload-list":!1,"before-upload":e.beforeAvatarUpload}},[e.addForm.card_img?t("img",{staticStyle:{"max-width":"400px","max-height":"300px"},attrs:{src:"__ROOT__"+e.addForm.card_img,alt:""}}):t("i",{staticClass:"el-icon-plus avatar-uploader-icon"})])],1)],1)],1),e._v(" "),t("el-row",[t("el-col",{attrs:{span:24}},[t("el-form-item",{attrs:{label:"身份证正面照"}},[t("el-upload",{staticClass:"card_front",attrs:{action:"{:U('Upload/index2')}",accept:"image/jpeg,image/png,image/jpg,image/gif,image/bmp","on-success":e.cardFront,data:e.pathInfo,headers:e.xuploadheader,multiple:!1,"show-upload-list":!1,"before-upload":e.beforeAvatarUpload}},[e.addForm.card_front?t("img",{staticStyle:{"max-width":"400px","max-height":"234px"},attrs:{src:"__ROOT__"+e.addForm.card_front,alt:""}}):t("i",{staticClass:"el-icon-plus avatar-uploader-icon"})])],1)],1)],1),e._v(" "),t("el-row",[t("el-col",{attrs:{span:24}},[t("el-form-item",{attrs:{label:"身份证反面照"}},[t("el-upload",{staticClass:"card_back",attrs:{action:"{:U('Upload/index2')}",accept:"image/jpeg,image/png,image/jpg,image/gif,image/bmp","on-success":e.cardBack,data:e.pathInfo,headers:e.xuploadheader,multiple:!1,"show-upload-list":!1,"before-upload":e.beforeAvatarUpload}},[e.addForm.card_back?t("img",{staticStyle:{"max-width":"400px","max-height":"234px"},attrs:{src:"__ROOT__"+e.addForm.card_back,alt:""}}):t("i",{staticClass:"el-icon-plus avatar-uploader-icon"})])],1)],1)],1)],1)],1)],1),e._v(" "),t("div",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[t("el-button",{on:{click:function(a){e.closeDialog()}}},[e._v("取 消")]),e._v(" "),t("el-button",{attrs:{type:"primary"},on:{click:function(a){e.addFormSubmit()}}},[e._v("确 定")])],1)],1)],1)},staticRenderFns:[]},r=t("/Xao")(l,o,!1,function(e){t("MSFi")},"data-v-5ce7aba0",null).exports,i={name:"editDialog",props:{editOpen:{type:Boolean,default:!1}},data:function(){return{activeName:"first",computedusers:[{user_id:"1",realname:"李青"},{user_id:"2",realname:"高鹏"},{user_id:"3",realname:"马娇"},{user_id:"4",realname:"吴继伟"}],topO:[{id:"1",name:"西北区"},{id:"2",name:"东南区"},{id:"3",name:"沿海区"}],typeList:["销售部","推广部","风控部","人事部"],state10:this.editOpen,editForm:{account:"",role_id:"",id:"",head:"",group_id:"",department_id:"",sex:0,phone:"",mphone:"",area_province:null,area_city:null,area_district:null,realname:"",address:"",qq:"",qq_nickname:"",weixin:"",weixin_nikname:"",id_card:"",card_img:"",card_front:"",card_back:""}}},methods:{handleClose:function(){this.$emit("add-window-close")},editFormSubmit:function(){console.log(this.editForm),this.state10=!1},closeDialog:function(){this.state10=!1}},watch:{editOpen:function(e,a){this.state10=e}}},s={render:function(){var e=this,a=e.$createElement,t=e._self._c||a;return t("div",[t("el-dialog",{attrs:{title:"编辑修改",visible:e.state10},on:{"update:visible":function(a){e.state10=a},close:e.handleClose}},[t("el-form",{ref:"editForm",attrs:{inline:!0,model:e.editForm}},[t("el-tabs",{attrs:{type:"card"},model:{value:e.activeName,callback:function(a){e.activeName=a},expression:"activeName"}},[t("el-tab-pane",{attrs:{label:"基本信息",name:"first"}},[t("el-row",[t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"登录账号",prop:"account"}},[t("el-input",{attrs:{disabled:!0,"auto-complete":"off"},model:{value:e.editForm.account,callback:function(a){e.$set(e.editForm,"account",a)},expression:"editForm.account"}})],1)],1),e._v(" "),t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"员工姓名",prop:"realname"}},[t("el-input",{attrs:{"auto-complete":"off"},model:{value:e.editForm.realname,callback:function(a){e.$set(e.editForm,"realname",a)},expression:"editForm.realname"}})],1)],1)],1),e._v(" "),1==e.departmentItem?t("el-row",[t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"所属部门",prop:"department_id"}},[t("el-select",{model:{value:e.editForm.department_id,callback:function(a){e.$set(e.editForm,"department_id",a)},expression:"editForm.department_id"}},e._l(e.departments,function(e){return t("el-option",{key:e.id,attrs:{label:e.name,value:e.id}})}))],1)],1),e._v(" "),t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"性别"}},[t("el-radio",{staticClass:"radio",attrs:{label:"1"},model:{value:e.editForm.sex,callback:function(a){e.$set(e.editForm,"sex",a)},expression:"editForm.sex"}},[e._v("男")]),e._v(" "),t("el-radio",{staticClass:"radio",attrs:{label:"2"},model:{value:e.editForm.sex,callback:function(a){e.$set(e.editForm,"sex",a)},expression:"editForm.sex"}},[e._v("女")])],1)],1)],1):e._e(),e._v(" "),t("el-row",[t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"头像"}},[t("img",{directives:[{name:"show",rawName:"v-show",value:e.editUploadImg,expression:"editUploadImg"}],staticStyle:{"max-width":"200px","max-height":"200px"},attrs:{src:e.editUpload,alt:""}}),e._v(" "),t("el-upload",{attrs:{action:"{:U('Upload/index2')}",accept:"image/jpeg,image/png,image/jpg,image/gif,image/bmp","on-success":e.editFormUploadSuccess,"on-error":e.addFormUploadError,data:e.pathInfo,headers:e.xuploadheader,multiple:!1,"show-upload-list":!1}},[t("el-button",{attrs:{size:"small",type:"primary"}},[e._v("点击上传")])],1)],1)],1)],1),e._v(" "),t("el-row",[t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"手机",prop:"mphone"}},[t("el-input",{attrs:{"auto-complete":"off"},model:{value:e.editForm.mphone,callback:function(a){e.$set(e.editForm,"mphone",a)},expression:"editForm.mphone"}})],1)],1),e._v(" "),t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"固话",prop:"phone"}},[t("el-input",{attrs:{"auto-complet":"off"},model:{value:e.editForm.phone,callback:function(a){e.$set(e.editForm,"phone",a)},expression:"editForm.phone"}})],1)],1)],1),e._v(" "),t("el-row",[t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"QQ号",prop:"qq"}},[t("el-input",{attrs:{"auto-complete":"off"},model:{value:e.editForm.qq,callback:function(a){e.$set(e.editForm,"qq",a)},expression:"editForm.qq"}})],1)],1),e._v(" "),t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"QQ昵称"}},[t("el-input",{attrs:{"auto-complet":"off"},model:{value:e.editForm.qq_nickname,callback:function(a){e.$set(e.editForm,"qq_nickname",a)},expression:"editForm.qq_nickname"}})],1)],1)],1),e._v(" "),t("el-row",[t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"微信号"}},[t("el-input",{attrs:{"auto-complete":"off"},model:{value:e.editForm.weixin,callback:function(a){e.$set(e.editForm,"weixin",a)},expression:"editForm.weixin"}})],1)],1),e._v(" "),t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"微信昵称"}},[t("el-input",{attrs:{"auto-complet":"off"},model:{value:e.editForm.weixin_nikname,callback:function(a){e.$set(e.editForm,"weixin_nikname",a)},expression:"editForm.weixin_nikname"}})],1)],1)],1),e._v(" "),t("el-row",[t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"身份证号"}},[t("el-input",{attrs:{"auto-complet":"off"},model:{value:e.editForm.id_card,callback:function(a){e.$set(e.editForm,"id_card",a)},expression:"editForm.id_card"}})],1)],1),e._v(" "),t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"区县"}},[t("el-select",{attrs:{placeholder:"请选择"},model:{value:e.editForm.area_district,callback:function(a){e.$set(e.editForm,"area_district",a)},expression:"editForm.area_district"}},e._l(e.districts,function(e){return t("el-option",{key:e.id,attrs:{label:e.name,value:e.id}})}))],1)],1)],1),e._v(" "),t("el-row",[t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"省份"}},[t("el-select",{ref:"editselect",attrs:{placeholder:"请选择"},on:{change:e.provinceChange},model:{value:e.editForm.area_province,callback:function(a){e.$set(e.editForm,"area_province",a)},expression:"editForm.area_province"}},e._l(e.provinces,function(e){return t("el-option",{key:e.id,attrs:{label:e.name,value:e.id}})}))],1)],1),e._v(" "),t("el-col",{attrs:{span:12}},[t("el-form-item",{attrs:{label:"城市"}},[t("el-select",{attrs:{placeholder:"请选择"},on:{change:e.cityChange},model:{value:e.editForm.area_city,callback:function(a){e.$set(e.editForm,"area_city",a)},expression:"editForm.area_city"}},e._l(e.cities,function(e){return t("el-option",{key:e.id,attrs:{label:e.name,value:e.id}})}))],1)],1)],1),e._v(" "),t("el-row"),e._v(" "),t("el-form-item",{attrs:{label:"住址"}},[t("el-input",{attrs:{type:"textarea",autosize:{minRows:2,maxRows:4},placeholder:"请输入内容"},model:{value:e.editForm.address,callback:function(a){e.$set(e.editForm,"address",a)},expression:"editForm.address"}})],1)],1),e._v(" "),t("el-tab-pane",{attrs:{label:"身份证照",name:"second"}},[t("el-row",[t("el-col",{attrs:{span:24}},[t("el-form-item",{attrs:{label:"手持身份证照"}},[t("el-upload",{staticClass:"card_img",attrs:{action:"{:U('Upload/index2')}",accept:"image/jpeg,image/png,image/jpg,image/gif,image/bmp","on-success":e.editCardImg,data:e.pathInfo,headers:e.xuploadheader,multiple:!1,"show-upload-list":!1,"before-upload":e.beforeAvatarUpload}},[e.editForm.card_img?t("img",{staticStyle:{"max-width":"400px","max-height":"300px"},attrs:{src:"__ROOT__"+e.editForm.card_img,alt:""}}):t("i",{staticClass:"el-icon-plus avatar-uploader-icon"})])],1)],1)],1),e._v(" "),t("el-row",[t("el-col",{attrs:{span:24}},[t("el-form-item",{attrs:{label:"身份证正面照"}},[t("el-upload",{staticClass:"card_front",attrs:{action:"{:U('Upload/index2')}",accept:"image/jpeg,image/png,image/jpg,image/gif,image/bmp","on-success":e.editCardFront,data:e.pathInfo,headers:e.xuploadheader,multiple:!1,"show-upload-list":!1,"before-upload":e.beforeAvatarUpload}},[e.editForm.card_front?t("img",{staticStyle:{"max-width":"400px","max-height":"234px"},attrs:{src:"__ROOT__"+e.editForm.card_front,alt:""}}):t("i",{staticClass:"el-icon-plus avatar-uploader-icon"})])],1)],1)],1),e._v(" "),t("el-row",[t("el-col",{attrs:{span:24}},[t("el-form-item",{attrs:{label:"身份证反面照"}},[t("el-upload",{staticClass:"card_back",attrs:{action:"{:U('Upload/index2')}",accept:"image/jpeg,image/png,image/jpg,image/gif,image/bmp","on-success":e.editCardBack,data:e.pathInfo,headers:e.xuploadheader,multiple:!1,"show-upload-list":!1,"before-upload":e.beforeAvatarUpload}},[e.editForm.card_back?t("img",{staticStyle:{"max-width":"400px","max-height":"234px"},attrs:{src:"__ROOT__"+e.editForm.card_back,alt:""}}):t("i",{staticClass:"el-icon-plus avatar-uploader-icon"})])],1)],1)],1)],1)],1)],1),e._v(" "),t("div",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[t("el-button",{on:{click:function(a){e.closeDialog()}}},[e._v("取 消")]),e._v(" "),t("el-button",{attrs:{type:"primary"},on:{click:function(a){e.editFormSubmit()}}},[e._v("确 定")])],1)],1)],1)},staticRenderFns:[]},n=t("/Xao")(i,s,!1,function(e){t("1cNm")},"data-v-7d304a52",null).exports,d=t("WgQz"),c=(t("0r1g"),t("imrz"),t("paWA"),t("9X1C")),m={name:"Employee",pageTitle:"员工管理",mixins:[d.a,c.a],components:{addDialog:r,editDialog:n},data:function(){return{depTypeName:"选择单位类型",typeList:["销售部","客服部","风控部","人事部","推广部","投顾部"],addDialog:!1,editDialog:!1,dataLoad:!1,total:100,searchForm:{typeValue:"",department:"",group:"",status:"",typeNumber:""},departments:[],groups:[],currentPage4:1,types:[{value:"1",name:"员工账号"},{value:"2",name:"员工姓名"},{value:"3",name:"手机号"},{value:"4",name:"QQ号"},{value:"5",name:"微信号"}],tableData:[{head:"",account:"李青",realname:"李青",department_name:"成都部",role:"普通员工",sex:"男",id_card:"52148962466558875112",phone:"028-12354",mphone:"13524674554",qq:"325641574",qq_nickname:"sb",weixin:"sdfsdf",weixin_nikname:"fsdfs",address:"天堂一街",ip:"192.168.0.11",location:"成都",lg_time:"2017-11-24 17:08:41",out_time:"2017-11-24 19:08:41",creator:"系统管理员",created_at:"2017-11-28 14:35:10"}]}},methods:{dataReload:function(){console.log(this.searchForm)},searchReset:function(){this.$refs.searchForm.resetFields()},refresh:function(){this.$refs.searchForm.resetFields()},handleEdit:function(e,a){console.log(a),this.editDialog=!0},handleDelete:function(e,a){},switchHandle:function(e,a){},openAddDialog:function(){},closeDialog:function(){},addFormSubmit:function(){console.log(this.addForm)},handleAddWindow:function(){this.addDialog=!1,this.editDialog=!1},mainTableLoad:function(e){this.toggleTableLoad(),this.tableData=e.items,this.total=e.total},currentChange:function(e){this.toggleTableLoad(),this.mainProxy.setPage(e).load()},toggleTableLoad:function(){this.dataLoad=!this.dataLoad},loadDepartment:function(e){this.departments=e.items},loadGroup:function(e){this.groups=e.items},onSearchChange:function(e){this.toggleTableLoad(),this.mainProxy.setExtraParam(e).load()}}},p={render:function(){var e=this,a=e.$createElement,t=e._self._c||a;return t("div",[t("el-row",[t("el-form",{ref:"searchForm",attrs:{inline:!0,model:e.searchForm}},[t("el-form-item",{staticStyle:{width:"140px"},attrs:{prop:"typeNumber"}},[t("el-select",{attrs:{size:"small",clearable:"",placeholder:"查询类型"},model:{value:e.searchForm.typeNumber,callback:function(a){e.$set(e.searchForm,"typeNumber",a)},expression:"searchForm.typeNumber"}},e._l(e.types,function(e){return t("el-option",{key:e.value,attrs:{label:e.name,value:e.value}})}))],1),e._v(" "),t("el-form-item",{attrs:{prop:"typeValue"}},[t("el-input",{attrs:{size:"small",placeholder:"请输入查询数据"},model:{value:e.searchForm.typeValue,callback:function(a){e.$set(e.searchForm,"typeValue",a)},expression:"searchForm.typeValue"}})],1),e._v(" "),t("el-form-item",{attrs:{prop:"department_id"}},[t("el-select",{attrs:{placeholder:"部门"},model:{value:e.searchForm.department_id,callback:function(a){e.$set(e.searchForm,"department_id",a)},expression:"searchForm.department_id"}},e._l(e.departments,function(e){return t("el-option",{key:e.id,attrs:{label:e.name,value:e.id}})}))],1),e._v(" "),t("el-form-item",{attrs:{prop:"group_id"}},[t("el-select",{attrs:{placeholder:"团队小组"},model:{value:e.searchForm.group_id,callback:function(a){e.$set(e.searchForm,"group_id",a)},expression:"searchForm.group_id"}},e._l(e.groups,function(e){return t("el-option",{key:e.id,attrs:{label:e.name,value:e.id}})}))],1),e._v(" "),t("el-form-item",{staticStyle:{width:"90px"},attrs:{prop:"status"}},[t("el-select",{attrs:{size:"small"},model:{value:e.searchForm.status,callback:function(a){e.$set(e.searchForm,"status",a)},expression:"searchForm.status"}},[t("el-option",{attrs:{value:"1",label:"在职"}}),e._v(" "),t("el-option",{attrs:{value:"-1",label:"离职"}})],1)],1),e._v(" "),t("el-form-item",[t("el-button",{attrs:{type:"primary",size:"small",icon:"search"},on:{click:function(a){e.searchToolChange("searchForm")}}},[e._v("查询\n                ")]),e._v(" "),t("el-button",{attrs:{size:"small",type:"primary"},on:{click:function(a){e.searchToolReset("searchForm")}}},[e._v("重置\n                ")])],1),e._v(" "),t("el-form-item",[t("el-tooltip",{attrs:{content:"点击刷新当前页面",placement:"right"}},[t("el-button",{attrs:{size:"small",type:"danger"}},[e._v("刷新")])],1)],1)],1)],1),e._v(" "),t("el-row",[t("el-col",[t("el-table",{directives:[{name:"loading",rawName:"v-loading",value:e.dataLoad,expression:"dataLoad"}],staticStyle:{width:"100%"},attrs:{data:e.tableData,border:""}},[t("el-table-column",{attrs:{label:"序号",width:"70",type:"index"}}),e._v(" "),t("el-table-column",{attrs:{prop:"head",label:"头像",width:"100",align:"center"}}),e._v(" "),t("el-table-column",{attrs:{prop:"account",label:"登录账号",width:"100"}}),e._v(" "),t("el-table-column",{attrs:{prop:"realname",label:"员工姓名",width:"150"}}),e._v(" "),t("el-table-column",{attrs:{prop:"department_name",label:"部门",width:"100"}}),e._v(" "),t("el-table-column",{attrs:{prop:"role",label:"职位",width:"100"}}),e._v(" "),t("el-table-column",{attrs:{prop:"sex",label:"性别",width:"80",align:"center"}}),e._v(" "),t("el-table-column",{attrs:{prop:"id_card",label:"身份证号",width:"192"}}),e._v(" "),t("el-table-column",{attrs:{prop:"phone",label:"固话",width:"140",align:"center"}}),e._v(" "),t("el-table-column",{attrs:{prop:"mphone",label:"手机",width:"140",align:"center"}}),e._v(" "),t("el-table-column",{attrs:{prop:"qq",label:"QQ号",width:"140",align:"center"}}),e._v(" "),t("el-table-column",{attrs:{prop:"qq_nickname",label:"QQ昵称",width:"180",align:"center"}}),e._v(" "),t("el-table-column",{attrs:{prop:"weixin",label:"微信号",width:"160",align:"center"}}),e._v(" "),t("el-table-column",{attrs:{prop:"weixin_nikname",label:"微信昵称",width:"190",align:"center"}}),e._v(" "),t("el-table-column",{attrs:{prop:"address",label:"地址",width:"190",align:"center"}}),e._v(" "),t("el-table-column",{attrs:{prop:"ip",label:"登录IP",width:"170","header-align":"center"}}),e._v(" "),t("el-table-column",{attrs:{prop:"location",label:"登录地点",width:"170",align:"center"}}),e._v(" "),t("el-table-column",{attrs:{prop:"lg_time",label:"最后登录时间",width:"175",align:"center"}}),e._v(" "),t("el-table-column",{attrs:{prop:"out_time",label:"最后退出时间",width:"175",align:"center"}}),e._v(" "),t("el-table-column",{attrs:{prop:"creator",label:"创建员工",width:"190",align:"center"}}),e._v(" "),t("el-table-column",{attrs:{prop:"created_at",label:"创建时间",width:"190"}}),e._v(" "),t("el-table-column",{attrs:{fixed:"right",label:"操作",width:"220",align:"center"},scopedSlots:e._u([{key:"default",fn:function(a){return[t("el-button",{attrs:{type:"success",size:"small"}},[e._v("编辑\n                        ")]),e._v(" "),t("el-button",{attrs:{type:"info",size:"small"}},[e._v("职能")]),e._v(" "),t("el-button",{attrs:{type:"danger",size:"small"}},[e._v("离职")])]}}])})],1)],1)],1),e._v(" "),t("el-row",[t("div",{staticClass:"pull-right"},[t("el-col",{attrs:{span:12}},[t("div",{staticClass:"grid-content bg-purple"},[t("el-button",{attrs:{type:"primary",size:"small"},on:{click:function(a){e.addDialog=!0}}},[e._v("添加员工")]),e._v(" "),t("el-button",{attrs:{type:"primary",size:"small"}},[e._v("修改账号密码")])],1)]),e._v(" "),t("el-col",{attrs:{span:12}},[t("el-pagination",{attrs:{"current-page":e.currentPage4,"page-size":100,layout:"total, prev, pager, next, jumper",total:e.total},on:{"current-change":e.currentChange}})],1)],1)]),e._v(" "),t("addDialog",{attrs:{"add-open":e.addDialog},on:{"add-window-close":e.handleAddWindow}}),e._v(" "),t("editDialog",{attrs:{"edit-open":e.editDialog},on:{"add-window-close":e.handleAddWindow}})],1)},staticRenderFns:[]},u=t("/Xao")(m,p,!1,function(e){t("dD/V")},"data-v-0b007cac",null);a.default=u.exports}});
//# sourceMappingURL=5.1462066891e5324287b7.js.map