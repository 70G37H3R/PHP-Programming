                <?php

                include('../class/Appointment.php');

				$object = new Appointment;

				if(!$object->is_login())
				{
				    header("location:".$object->base_url."");
				}

                if($_SESSION['type'] != 'Admin')
                {
                    header("location:".$object->base_url."");
                }

                include('header.php');

                ?>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Thống Kê Nhanh</h1>

                    <!-- Content Row -->
                    <div class="row row-cols-5">
                        
                        <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Số Lượng Cuộc Hẹn Hôm Nay</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_today_appointment(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-notes-medical fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Số Lượng Cuộc Hẹn Hôm Qua</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_yesterday_appointment(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-notes-medical fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Số Lượng Cuộc Hẹn Trong Tuần Này</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_seven_day_appointment(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-notes-medical fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Số lượng Bác Sĩ</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_doctor(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Số Lượng Bệnh Nhân</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_patient(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-procedures fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-5">
                        <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Số Lượng Đơn Thuốc Hôm Nay</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_today_prescription(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-capsules fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Số Lượng Đơn Thuốc Hôm Qua</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_yesterday_prescription(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-capsules fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Số Lượng Đơn Thuốc Trong Tuần Này</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_seven_day_prescription(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-capsules fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php
                include('footer.php');
                ?>