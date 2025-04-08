                    
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card card-h-100">
                                <div class="card-body">
                                    <div class="float-end">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle text-reset" href="#" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <span class="fw-semibold">Exporter vers :</span> <span class="text-muted">Choisir...<i
                                                        class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#"><i class="fa fa-file-excel"></i> Feuille de calcul Excel</a>
                                                <!--<a class="dropdown-item" href="#"><i class="fa fa-file-pdf"></i> Fichier PDF</a>-->
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="card-title mb-4">Statistiques</h4>

                                    <div class="mt-1">
                                        <div class="row justify-content-center">
                                            <div class="col-xl-6">
                                                <div class="row gy-4 text-center mb-0">
                                                    <div class="col-sm-4">
                                                        <h4 class="text-primary mb-1"><?php echo number_format($valeur_initiale_budget,0,',',' '); ?> FCFA</h4>
                                                        <div class="text-muted d-inline-block fw-normal font-size-15">Budget alloué</div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <h4 class="mb-1">8</h4>
                                                        <div class="text-muted d-inline-block fw-normal font-size-15">Formations effectuées</div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <h4 class="mb-1">52</h4>
                                                        <div class="text-muted d-inline-block fw-normal font-size-15">Personnes formées</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <div id="sales-analytics-chart" class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->