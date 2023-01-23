<div class="modal fade mt-3" id="myModal2" style="direction: rtl;">
    <div class="modal-dialog modal-md" id="editlist2" style="margin-top: 100px;margin-left: 450px">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 600px " >
                <div class="row" style="width: 100%">
                    <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">جزئیات برنامه تعمیراتی</p></div>
                    <div class="col-6">
                        <div class="row" style="width: 100%">
                            <div class="col-10">.</div>
                            <div class="col-2">
                                <button type="button" class="close" data-dismiss="modal" style="text-align: center;display: inline;color: white">&times;</button>
                            </div>
                        </div>

                    </div>
                </div>


            </div>

            <!-- List -->
            <div class="container"  style="margin: auto;background-color:white;width: 600px ;height: 280px;overflow-y: scroll">
                <div class="row mt-3">
                    <div class="col">
                        <div class="row">
                            <div class="col-6">
                                <p style="font-family: Tahoma;font-size: smaller;color: black;font-weight: bold;">مربوط به واحد:</p>
                            </div>
                            <div class="col-6" style="text-align: right">
                                <p id="ID_UN_D" style="font-family: Tahoma;font-size: smaller;color: black;color: #1c7430;font-weight: bold"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col" style="height:25px">
                        <div class="row">
                            <div class="col-6">
                                <p style="font-family: Tahoma;font-size: smaller;color: black;font-weight: bold;font-weight: bold">نوع تعمیرات:</p>
                            </div>
                            <div class="col-6" style="height:25px;text-align: right">
                                <p style="font-family: Tahoma;font-size: small;color: black;text-align: right;color: #1c7430;font-weight: bold" id="ID_TT_D"></p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col" style="height:25px">
                        <div class="row">
                            <div class="col-3" style="height:25px">
                                <p style="font-family: Tahoma;font-size: xx-small;color: black;font-weight: bold;">نام شرکت تعمیر کننده:</p>
                            </div>
                            <div class="col-5" style="height:25px;text-align: right">
                                <p style="font-family: Tahoma;font-size: xx-small;color: black;color:  #1c7430;font-weight: bold" id="ID_TA_D"></p>
                            </div>
                            <div class="col-2" style="height:25px">
                                <p style="font-family: Tahoma;font-size: xx-small;color: black;font-weight: bold;">ثبت کننده:</p>
                            </div>
                            <div class="col-2" style="text-align: right">
                                <p id="ID_USER_D" style="font-family: Tahoma;font-size: xx-small;color: black;color:  #1c7430;font-weight: bold;"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col" style="height:25px;text-align: right">
                        <p style="font-family: Tahoma;font-size: smaller;color: black;margin-right: 15px;font-weight: bold;">مشخصات تعمیرات:</p>
                    </div>
                </div>
                <div class="row" style="width: 100%">
                    <div class="col-7">
                        <div id="person_div" class="col" style="height:50px">
                            <table id="person_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 5px;border: 1px solid black;margin-right: 10px">
                                <tr style="color: black">
                                    <td class="person">کد تعمیرات</td>
                                    <td class="person2"><p class="person3" id="ID_T_D"></p></td>
                                </tr>
                                <tr style="color: black">
                                    <td class="person">تاریخ شروع تعمیرات</td>
                                    <td class="person2"><p class="person3" id="DATE_BEGIN_SH_D"></p></td>
                                </tr>
                                <tr style="color: black">
                                    <td class="person">تاریخ پایان تعمیرات</td>
                                    <td class="person2"><p class="person3" id="DATE_END_SH_D"></p></td>
                                </tr>
                                <tr style="color: black">
                                    <td class="person">کارکرد واقعی</td>
                                    <td class="person2"><p class="person3" id="TIME_WORK_REAL_D"></p></td>
                                </tr>
                                <tr style="color: black">
                                    <td class="person">کارکرد معادل</td>
                                    <td class="person2"><p class="person3" id="TIME_WORK_EQUAL_D"></p></td>
                                </tr>
                                <tr style="color: black">
                                    <td class="person">فایل الصاقی</td>
                                    <td class="person2" style="direction: ltr"><a id="FILE_NAME_D"></a></td>

                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-5">
                            <div class="row">
                                <div class="col-3">
                                   <p style="font-family: Tahoma;font-size: small;">توضیحات:</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" style="word-wrap: break-word;height: 80px;font-family: Tahoma;font-size: smaller;direction: rtl;text-align: right">
                                    <p class="person3" id="DISCRIPTION_D"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div id="person_div" class="col" style="height:50px">
                                        <table id="person_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 5px;border: 1px solid black;margin-right: 10px">
                                            <tr style="color: black">
                                                <td class="person">تایید شده</td>
                                                <td class="person2"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre" id="CONFIR_D2"></td>
                                            </tr>
                                            <tr style="color: black">
                                                <td class="person">انجام شده</td>
                                                <td class="person2"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre" id="ANGAM_D2"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer bg-info" style="height: 20px;width:600px"></div>

        </div>
    </div>
</div>