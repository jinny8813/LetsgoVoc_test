<?= $this->extend("layout/template")?>
<?= $this->section('content')?>
<section class="min-vh-100 bg_light">
    <div class="w-100">
        <img class="img-fluid" src="<?= base_url('../../public/assets/images/banner.jpg') ?>" alt="">
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="position-relative">
                    <div class="position-absolute top-100 start-50 translate-middle d-flex justify-content-center align-items-center w-100">
                        <div class="card w-75">
                            <div class="card-body">
                                <div class="text-center fs-3"><?= esc($userData['nickname'])?>的個人主頁</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container pt-5">
        <div class="row justify-content-center mb-3">
            <div class="col-md-8 col-12">
                <div class="fs-5 mb-2"><?= esc($date)?>學習快報</div>
            </div>
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-2"><small>本週學習打卡紀錄</small></div>
                        <div id="calender"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-4 col-6">
                <div class="card">
                    <div class="card-body">
                        <div><small>今日測驗數</small></div>
                        <div class="float-end fs-3"><strong>*200</strong></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-6">
                <div class="card">
                    <div class="card-body">
                        <div><small>累積測驗數</small></div>
                        <div class="float-end fs-3"><strong>881003</strong></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-4 col-6">
                <div class="card">
                    <div class="card-body">
                        <div><small>累積字卡數</small></div>
                        <div class="float-end fs-3"><strong>999</strong></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-6">
                <div class="card">
                    <div class="card-body">
                        <div><small>累積天數</small></div>
                        <div class="float-end fs-3"><strong>28</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-6" style="background-color:#2c4c01">
                <div class="text-center fs-5 py-5"><a class="a_white" href="<?= base_url('/books') ?>">書本列表</a></div>
            </div>
            <div class="col-md-3 col-6" style="background-color:#628100">
                <div class="text-center fs-5 py-5"><a class="a_white" href="#">所有字卡</a></div>
            </div>
            <div class="col-md-3 col-12" style="background-color:#dfc403">
                <div class="text-center fs-5 py-5"><a class="a_white" href="<?= base_url('/quizlets') ?>">翻卡測驗</a></div>
            </div>
            <div class="col-md-4 col-6" style="background-color:#c9d1d4">
                <div class="text-center fs-5 py-5"><a class="a_white" href="<?= base_url('/statistics') ?>">統計分析</a></div>
            </div>
            <div class="col-md-8 col-6" style="background-color:#505c58">
                <div class="text-center fs-5 py-5"><a class="a_white" href="#">個人設定</a></div>
            </div>
        </div>
    </div>
</section>
<script>
    const the_week_log_count=<?php echo json_encode($the_week_log_count); ?>;
    console.log(the_week_log_count);

    function getCalender(data){
        let calender = document.getElementById('calender');
        let len = Object.keys(data).length;
        let calBody = `
                <div class="row justify-content-center mb-2">
                    <div class="col text-center">mon</div>
                    <div class="col text-center">tue</div>
                    <div class="col text-center">wed</div>
                    <div class="col text-center">thu</div>
                    <div class="col text-center">fri</div>
                    <div class="col text-center">sat</div>
                    <div class="col text-center">sun</div>
                </div>`;
        let weekday = 1;
        let first = new Date(data[0].date);
        while(weekday != first.getDay()){
            if(weekday == 1)
                calBody = calBody + `<div class="row justify-content-center mb-2">`;
            calBody = calBody + `<div class="col p-0 m-0"></div>`;
            weekday++;
        }
        data.forEach((value, index) => {
            if(weekday == 1)
                calBody = calBody + `<div class="row justify-content-center mb-2">`;
            if(value.count == 0)
                calBody = calBody + `<div class="col p-0 m-0 d-flex justify-content-center"><div class="text-center dot">${value.date.slice(-2)}</div></div>`;
            else
                calBody = calBody + `<div class="col p-0 m-0 d-flex justify-content-center"><div class="text-center dot dot-fill">${value.date.slice(-2)}</div></div>`;
            if(weekday == 7){
                calBody = calBody + `</div>`;
                weekday = 1;
            }else{
                weekday++
            }
        });
        while(weekday <= 7 && weekday > 1){
            calBody = calBody + `<div class="col p-0 m-0"></div>`;
            if(weekday == 7)
                calBody = calBody + `</div>`;
            weekday++;
        }
        calender.innerHTML = calBody;
    }

    getCalender(the_week_log_count);
</script>
<?= $this->endSection()?>