<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Auth::routes();
Route::get('/', 'WebControllers\HomeController@index')->name('home');
Route::get('/home', 'WebControllers\HomeController@index')->name('home');
Route::get('/help', 'WebControllers\HomeController@help')->name('help');


/**
 * Query test routes
 */
//Route::get('/queryspeedtest', 'QuerySpeedTestController@index');

/** RHS Routes */
Route::get('/rhs/rhs-home', 'WebControllers\RHSController@index')->name('rhs-home');
Route::get('/rhs/shape-compare', 'WebControllers\RHSController@ShapeCompare')->name('shape-compare');
Route::get('/rhs/live-furnace-trace', 'WebControllers\RHSController@LiveFurnaceTrace')->name('live-furnace-trace');
Route::get('/rhs/section-furnace-trace', 'WebControllers\RHSController@SectionFurnaceTrace')->name('section-furnace-trace');
Route::get('/rhs/furnace-summary', 'WebControllers\RHSController@FurnaceSummary')->name('furnace-summary');
Route::get('/rhs/furnace-dashboard', 'WebControllers\RHSController@FurnaceDashboard')->name('furnace-dashboard');
Route::get('/rhs/straightness-analysis', 'WebControllers\RHSController@StraightnessAnalysis')->name('straightness-analysis');
Route::get('/rhs/straightness-reject-rate-by-week', 'WebControllers\RHSController@StraightnessRejectRateByWeek')->name('straightness-reject-rate-by-week');
Route::get('/rhs/manual-measure-analysis', 'WebControllers\RHSController@ManualMeasure')->name('manual-measure-analysis');
Route::get('/rhs/manual-measure-average-analysis', 'WebControllers\RHSController@ManualMeasureAVGAnalysis')->name('manual-measure-average-analysis');
Route::get('/rhs/straightness-live-feed', 'WebControllers\RHSController@StraightnessLiveFeed')->name('straightness-live-feed');
Route::get('/rhs/straightness-dashboard', 'WebControllers\RHSController@StraightnessDashboard')->name('straightness-dashboard');
Route::get('/rhs/straightness-heatmap', 'WebControllers\RHSController@StraightnessHeatMap')->name('straightness-heatmap');
Route::get('/rhs/quench-live-feed', 'WebControllers\RHSController@QuenchLiveFeed')->name('rhs-quench-live-feed');
Route::get('/rhs/quench-summary', 'WebControllers\RHSController@QuenchSummary')->name('quench-summary');
Route::get('/rhs/section-cooling-trace', 'WebControllers\RHSController@SectionCoolingTrace')->name('section-cooling-trace');
Route::get('/rhs/rhs-defects', 'WebControllers\RHSController@Defects')->name('rhs-defects');
Route::get('/rhs/rhs-throughputs', 'WebControllers\RHSController@Throughputs')->name('rhs-throughputs');
Route::get('/rhs/rhs-changelog', 'WebControllers\RHSController@ChangeLog')->name('rhs-changelog');
Route::get('/rhs/rhs-changelog-view', 'WebControllers\RHSController@ChangeLogTableView')->name('rhs-changelog-view');
Route::get('/rhs/rhs-dashboard', 'WebControllers\RHSController@RHSDashboard')->name('rhs-dashboard');
Route::get('/rhs/zumbach-averages-dashboard', 'WebControllers\RHSController@ZumbachAveragesDashboard')->name('zumbach-averages-dashboard');
Route::get('/rhs/furnace-temp-defect-monitor', 'WebControllers\RHSController@furnaceTempDefectMonitor')->name('furnace-temp-defect-monitor');
Route::get('/rhs/furnace-temp-defect-dashboard', 'WebControllers\RHSController@furnaceTempDefectDashboard')->name('furnace-temp-defect-dashboard');
Route::get('/rhs/stretch-factors', 'WebControllers\RHSController@RHSStretchFactors')->name('stretch-factors');
Route::get('/rhs/stretch-factor-live-calculator', 'WebControllers\RHSController@RHSStretchFactorLiveCalculator')->name('stretch-factor-live-calculator');

Route::resource('users', 'WebControllers\UserController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::resource('roles', 'WebControllers\RoleController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::resource('target', 'WebControllers\TargetController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::resource('global-settings', 'WebControllers\GlobalSettingsController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::resource('take2', 'Take2Controllers\Take2RecordController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.

Route::resource('shift-eng-log', 'WebControllers\ShiftEngLogController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.

//Route::resource('elec-eng-log', 'WebControllers\ElecEngLogController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
//Route::resource('mech-eng-log', 'WebControllers\MechEngLogController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
//Route::resource('rhs-log-meta', 'WebControllers\RHSLogMetaController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.


/**
 * WMShiftLogs
 */

Route::resource('wm-shift-log', 'WebControllers\WMShiftLogController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.

/**
 * Varnish Checks
 */
Route::resource('varnish-checks', 'WebControllers\VarnishCheckController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.


/**
 * Query ODBCViewer
 */

//Route::get('ODBCMXViewer', 'ODBCMXViewerController@index');


/**
 * Weld Head Scrap
 *
 */

Route::resource('weld-head-scrap', 'WebControllers\WeldHeadScrapController');


/**
 * Audit
 */
Route::get('/audit/home', 'WebControllers\AuditController@home')->name('audit-home');
Route::resource('audit', 'WebControllers\AuditController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::resource('audit-files', 'WebControllers\AuditFilesController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.

/**
 * NCR
 */
Route::get('/ncr/home', 'WebControllers\NCRController@home')->name('ncr-home');
Route::resource('ncr', 'WebControllers\NCRController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::resource('ncr-files', 'WebControllers\NCRFilesController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.

/**


/**
 * Training Stats
 */
Route::get('/training-stats/home', 'WebControllers\TrainingStatsController@home')->name('training-stats-home');


Route::get('/moc/home', 'WebControllers\MOCController@home')->name('moc-home');
Route::get('/moc/create-significant', 'WebControllers\MOCController@createSignificant')->name('create-significant');
Route::get('/moc/show-significant', 'WebControllers\MOCController@showSignificant')->name('show-significant');
Route::post('/moc/store-significant', 'WebControllers\MOCController@storeSignificant')->name('moc-store-significant');
Route::get('/moc/edit-significant', 'WebControllers\MOCController@editSignificant')->name('moc-edit-significant');
Route::post('/moc/update-significant', 'WebControllers\MOCController@updateSignificant')->name('moc-update-significant');
Route::resource('moc', 'WebControllers\MOCController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::resource('moc-department', 'WebControllers\MocDepartmentController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::resource('moc-authoriser', 'WebControllers\MocAuthoriserController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::resource('moc-department-authoriser', 'WebControllers\MocDepartmentAuthoriserController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::resource('moc-area-relation', 'WebControllers\MocAreaRelationController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::resource('moc-control', 'WebControllers\MocControlController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::resource('moc-user-action', 'WebControllers\MocUserActionController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::resource('moc-files', 'WebControllers\MocFilesController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.

// Inlc custom routes before resource method called. Otherwise, laravel will load blank page.
Route::get('/pivot-configs/pivot-configs-list', 'PivotControllers\PivotConfigsController@PivotConfigList')->name('pivot-configs-list');
Route::resource('pivot-configs', 'PivotControllers\PivotConfigsController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::resource('pivot-user-configs', 'PivotControllers\PivotUserConfigsController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::get('/logon-activity', 'WebControllers\UserController@LogonActivity')->name('logon-activity');

/** All Mills Routes */
Route::resource('change-log', 'WebControllers\ChangeLogController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::get('all-mills/change-log/index', 'WebControllers\ChangeLogController@index')->name('change-log');

/** Casing Mill Tracking Routes */
Route::get('/casing/', 'WebControllers\CasingController@index')->name('casing-home');
Route::get('/casing/furnace-dashboard', 'WebControllers\CasingController@FurnaceDashboard')->name('casing-furnace-dashboard');
Route::get('/casing/casing-cooling-dashboard', 'WebControllers\CasingController@CasingCoolingDashboard')->name('casing-cooling-dashboard');
Route::get('/casing/casing-cooling-summary', 'WebControllers\CasingController@CasingCoolingSummary')->name('casing-cooling-summary');
Route::get('/casing/casing-temperature-control', 'WebControllers\CasingController@CasingTemperatureControl')->name('casing-temperature-control');
Route::get('/casing/section-furnace-trace', 'WebControllers\CasingController@SectionFurnaceTrace')->name('section-furnace-trace');

/** Management Mill Tracking Routes */

Route::get('/mngr-tracking/', 'WebControllers\MngrTracking@index')->name('mngr-tracking-home');
Route::get('/mngr-tracking/wip', 'WebControllers\MngrTracking@WIP')->name('wip');
Route::get('/mngr-tracking/order-status', 'WebControllers\MngrTracking@OrderStatus')->name('order-status');
Route::get('/mngr-tracking/pipe-list', 'WebControllers\MngrTracking@PipeList')->name('pipe-list');
Route::get('/mngr-tracking/stock-pipe-list', 'WebControllers\MngrTracking@StockPipeList')->name('stock-pipe-list');
Route::get('/mngr-tracking/pipe-list-status-code', 'WebControllers\MngrTracking@PipeListByStatusCode')->name('pipe-list-status-code');
Route::get('/mngr-tracking/pipe-list-dept', 'WebControllers\MngrTracking@PipeListByDept')->name('pipe-list-dept');
Route::get('/mngr-tracking/throughput', 'WebControllers\MngrTracking@PositionThroughput')->name('throughput');
Route::get('/mngr-tracking/havs-pro', 'WebControllers\MngrTracking@HavsPro')->name('havs-pro');
Route::get('/mngr-tracking/scrap-dg-pipe-list', 'WebControllers\MngrTracking@ScrapDowngradePipeList')->name('scrap-dg-pipe-list');
Route::get('/mngr-tracking/test-piece-order-pipe-tracking', 'WebControllers\MngrTracking@TestPieceOrderPipeTracking')->name('test-piece-order-pipe-tracking');
Route::get('/mngr-tracking/coil-desp-not-received', 'WebControllers\MngrTracking@CoilDespNotReceived')->name('coil-desp-not-received');
Route::get('/mngr-tracking/scrap-analysis', 'WebControllers\MngrTracking@ScrapAnalysis')->name('scrap-analysis');
Route::get('/mngr-tracking/production-stats', 'WebControllers\MngrTracking@ProductionStats')->name('production-stats');
Route::get('/mngr-tracking/stocks-summary', 'WebControllers\MngrTracking@StocksSummary')->name('stocks-summary');
Route::get('/mngr-tracking/mill-pen-tracking', 'WebControllers\MngrTracking@MillPenTracking')->name('mill-pen-tracking');


Route::get('/mngr-tracking/throughputDownload', 'ApiControllers\MngrTrackingApiController@ThroughputDataDownload')->name('throughputDownload');

/** SLITTER Mill Tracking Routes */

Route::get('/slitter/', 'WebControllers\SlitterController@index')->name('slitter-home');
Route::get('/slitter/slit-coil-lookup', 'WebControllers\SlitterController@SlitCoilLookup')->name('slit-coil-lookup');
Route::get('/slitter/slitter-main-dashboard', 'WebControllers\SlitterController@dashboard')->name('slitter-main-dashboard');


/** Admin Tools */

Route::get('/admin-tools/home', 'WebControllers\AdminToolsController@index')->name('admin-tools-home');
Route::get('/admin-tools/dashboard', 'WebControllers\AdminToolsController@Dashboard')->name('admin-tools-dashboard');

/** Pivot Views */
Route::get('/pivots/pivots-home', 'WebControllers\PivotController@Index')->name('pivots-home');
Route::get('/pivots/weld-mill-stoppages-pivot', 'WebControllers\PivotController@WeldMillStoppagesPivot')->name('weld-mill-stoppages-pivot');
Route::get('/pivots/slitter-stoppages-pivot', 'WebControllers\PivotController@SlitterStoppagesPivot')->name('slitter-stoppages-pivot');
Route::get('/pivots/coil-pipe-pivot', 'WebControllers\PivotController@CoilPipePivot')->name('coil-pipe-pivot');
Route::get('/pivots/tracking-pivot', 'WebControllers\PivotController@TrackingPivot')->name('tracking-pivot');
Route::get('/pivots/order-tracking-pivot', 'WebControllers\PivotController@OrderTrackingPivot')->name('order-tracking-pivot');
Route::get('/pivots/stock-tracking-pivot', 'WebControllers\PivotController@StockTrackingPivot')->name('stock-tracking-pivot');
Route::get('/pivots/surplus-tracking-pivot', 'WebControllers\PivotController@SurplusTrackingPivot')->name('surplus-tracking-pivot');
Route::get('/pivots/non-prime-tracking-pivot', 'WebControllers\PivotController@NonPrimeTrackingPivot')->name('non-prime-tracking-pivot');
Route::get('/pivots/coil-tracking-pivot', 'WebControllers\PivotController@CoilTrackingPivot')->name('coil-tracking-pivot');
Route::get('/pivots/adhoc-pivot-loader', 'WebControllers\PivotController@AdHocPivotLoader')->name('adhoc-pivot-loader');
Route::get('/pivots/stoppages-pivot', 'WebControllers\PivotController@StoppagesPivot')->name('stoppages-pivot');
Route::get('/pivots/test-piece-pivot', 'WebControllers\PivotController@TestPieceManagementPivot')->name('test-piece-pivot');
Route::get('/pivots/test-piece-result-pivot', 'WebControllers\PivotController@TestPieceResultManagementPivot')->name('test-piece-result-pivot');
Route::get('/pivots/despatch-pivot', 'WebControllers\PivotController@DespatchPivot')->name('despatch-pivot');
Route::get('/pivots/rhs-defect-pivot', 'WebControllers\PivotController@RHSDefectPivot')->name('rhs-defect-pivot');

///** Pivot Dashboard */
//Route::get('pivot-dashboard/pivot-dashboard-home', 'WebControllers\PivotDashboardController@Index')->name('pivot-dashboard-home');

/** Weld Mill */
Route::get('/weld-mill/home', 'WebControllers\WeldMillController@index')->name('weld-mill-home');
Route::get('/weld-mill/main-dashboard', 'WebControllers\WeldMillController@MainDashboard')->name('weld-mill-main-dashboard');
Route::get('/weld-mill/weld-head-dashboard', 'WebControllers\WeldMillController@WeldHeadDashboard')->name('weld-head-dashboard');
Route::get('/weld-mill/plc-weld-head-dashboard', 'WebControllers\WeldMillController@PLCWeldHeadDashboard')->name('plc-weld-head-dashboard');
Route::get('/weld-mill/annealer-dashboard', 'WebControllers\WeldMillController@AnnealerDashboard')->name('annealer-dashboard');
Route::get('/weld-mill/manual-measure-analysis', 'WebControllers\WeldMillController@ManualMeasure')->name('wm-manual-measure-analysis');
//Route::get('/weld-mill/dimensional-verification', 'WebControllers\WMDimensionalVerification@DimensionalVerification')->name('dimensional-verification');
Route::get('/weld-mill/hook-and-camber-coil-data', 'WebControllers\WeldMillController@HookAndCamberCoilData')->name('hook-and-camber-coil-data');
Route::get('/weld-mill/weld-mill-stoppage-comment-adder', 'WebControllers\WeldMillController@WeldMillStoppageCommentAdder')->name('weld-mill-stoppage-comment-adder');


Route::resource('wm-dimensional-verification', 'WebControllers\WMDimensionalVerification'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::resource('wm-serious-concern', 'WebControllers\WMSeriousConcernController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::resource('pipe-quality-logs', 'WebControllers\PipeQualityLogsController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.

/** Report Routes */

Route::get('/reports/stock-report', 'WebControllers\ReportController@StockReport')->name('stock-report');

/** Order tracking routes */

Route::get('/order-tracking/order-tracking-home', 'WebControllers\OrderTrackingController@Index')->name('order-tracking-home');
Route::get('/order-tracking/order-pipe-list-view', 'WebControllers\OrderTrackingController@OrderPipeListView')->name('order-pipe-list-view');
Route::get('/order-tracking/generate-tally-list', 'WebControllers\OrderTrackingController@GenerateTallyList')->name('generate-tally-list');
Route::get('/order-tracking/block-pipe-list-view', 'WebControllers\OrderTrackingController@BlockPipeListView')->name('block-pipe-list-view');

/**
 * TestPieceManagementRoutes
 */
Route::get('/tpm/', 'WebControllers\TestPieceManagementController@testPieceManagementIndex')->name('test-piece-management-home');
Route::get('/tpm/tpm-summary', 'WebControllers\TestPieceManagementController@testPieceManagementSummary')->name('test-piece-management-summary');
Route::get('/tpm/test-result-distribution', 'WebControllers\TestPieceManagementController@testPieceResultDistribution')->name('test-piece-result-distribution');

/** Rounds Finishing routes */

Route::get('/rounds-finishing/', 'WebControllers\RoundsFinishingController@roundsFinishingHome')->name('rounds-finishing-home');
Route::get('/rounds-finishing/end-laser-summary', 'WebControllers\RoundsFinishingController@endLaserSummary')->name('end-laser-summary');
Route::get('/rounds-finishing/end-laser-dashboard', 'WebControllers\RoundsFinishingController@endLaserDashboard')->name('end-laser-dashboard');
Route::get('/rounds-finishing/dashboard', 'WebControllers\RoundsFinishingController@dashboard')->name('rf-dashboard');

/** Data Exports Routes */
Route::get('/data-exports', 'WebControllers\DataExportController@index')->name('data-exports');
Route::get('/data-exports/weld-mill-stoppage-data-exporter', 'WebControllers\DataExportController@weldMillDataExporter')->name('weld-mill-stoppage-data-exporter');
Route::get('/data-exports/slitter-stoppage-data-exporter', 'WebControllers\DataExportController@slitterMillDataExporter')->name('slitter-stoppage-data-exporter');
Route::get('/data-exports/other-stoppages-data-exporter', 'WebControllers\DataExportController@otherStoppagesDataExporter')->name('other-stoppages-data-exporter');
Route::get('/data-exports/other-stoppages-data-exporter', 'WebControllers\DataExportController@otherStoppagesDataExporter')->name('other-stoppages-data-exporter');
Route::get('/data-exports/rhs-straightness-data-exporter', 'WebControllers\DataExportController@rhsStraightnessDataExporter')->name('rhs-straightness-data-exporter');
Route::get('/data-exports/zumbach-laser-data-exporter', 'WebControllers\DataExportController@zumbachLaserDataExporter')->name('zumbach-laser-data-exporter');
Route::get('/data-exports/onsite-report-data-exporter', 'WebControllers\DataExportController@onsiteReportDataExporter')->name('onsite-report-data-exporter');
Route::get('/data-exports/linehist-report-data-exporter', 'WebControllers\DataExportController@linehistReportDataExporter')->name('linehist-report-data-exporter');
Route::get('/data-exports/var-settings-report-data-exporter', 'WebControllers\DataExportController@varSettingsReportDataExport')->name('varsettings-report-data-exporter');
Route::get('/data-exports/blockf-exporter', 'WebControllers\DataExportController@BlockfDataExport')->name('blockf-exporter');


/** Macro Data Routes */
Route::resource('wm-macros', 'WebControllers\MacroDataController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::get('wm-macros/remove-image/{id}', 'WebControllers\MacroDataController@destroyImage')->name('remove-macro-image');

/** WM Gauge Change Routes */
Route::get('wm-gauge-change/export-gauge-change-data', 'WebControllers\WMGaugeChangeController@exportGaugeChangeAndVariableData');
Route::resource('wm-gauge-change', 'WebControllers\WMGaugeChangeController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.

/** WM Serious Concerns Routes */
//Route::get('wm-gauge-change/export-gauge-change-data', 'WebControllers\WMGaugeChangeController@exportGaugeChangeAndVariableData');
Route::resource('wm-gauge-change', 'WebControllers\WMGaugeChangeController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.

/** Annealer Routes */
Route::resource('annealer-pre-start-checks', 'WebControllers\AnnealerPreStartChecksController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
//Route::get('wm-macros/remove-image/{id}', 'WebControllers\MacroDataController@destroyImage')->name('remove-macro-image');
Route::get('/api/exportAnnealerPreStartChecksToCSV', 'ApiControllers\AnnealerPreStartChecksApiController@exportAnnealerPreStartChecksToCSV')->name('exportAnnealerPreStartChecksToCSV');


/** USR Routes */
Route::resource('usr', 'WebControllers\USRController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::get('usr/remove-image/{id}', 'WebControllers\USRController@destroyImage')->name('remove-usr-image');
Route::resource('usr-files', 'WebControllers\UsrFilesController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.

/** Engineering Routes */
Route::get('/engineering', 'WebControllers\EngineeringController@index')->name('engineering-home');
Route::get('/engineering/wm-stoppage-analysis-dashboard', 'WebControllers\EngineeringController@wmStoppageAnalysisDashboard')->name('wm-stoppage-analysis-dashboard');
Route::get('/engineering/cold-finishing-stoppage-analysis-dashboard', 'WebControllers\EngineeringController@coldFinishingStoppageAnalysisDashboard')->name('cold-finishing-stoppage-analysis-dashboard');
Route::get('/engineering/rhs-stoppage-analysis-dashboard', 'WebControllers\EngineeringController@rhsStoppageAnalysisDashboard')->name('rhs-stoppage-analysis-dashboard');
Route::get('/engineering/rhs-saw-stoppage-analysis-dashboard', 'WebControllers\EngineeringController@rhsSawStoppageAnalysisDashboard')->name('rhs-saw-stoppage-analysis-dashboard');
Route::get('/engineering/chs-stoppage-analysis-dashboard', 'WebControllers\EngineeringController@chsStoppageAnalysisDashboard')->name('chs-stoppage-analysis-dashboard');
Route::get('/engineering/main-dashboard', 'WebControllers\EngineeringController@engineeringMainDashboard')->name('engineering-main-dashboard');
Route::get('/engineering/hydro-max-end-load', 'WebControllers\EngineeringController@hydroMaxEndLoad')->name('hydro-max-end-load');
Route::get('/engineering/slitter-stoppage-analysis-dashboard', 'WebControllers\EngineeringController@slitterStoppageAnalysisDashboard')->name('slitter-stoppage-analysis-dashboard');

/** Finance Routes */
Route::get('/finance/plant-finance', 'WebControllers\FinanceController@plantFinance')->name('plant-finance');

Route::resource('finance-global-variable', 'WebControllers\FinanceGlobalVariableController');
Route::resource('speed-standards', 'WebControllers\SpeedStandardsController');
Route::get('/finance/wm-finance', 'WebControllers\FinanceController@wmFinance')->name('wm-finance');
Route::get('/finance/cold-finishing-finance', 'WebControllers\FinanceController@coldFinishingFinance')->name('cold-finishing-finance');
Route::get('/finance/rhs-finance', 'WebControllers\FinanceController@rhsFinance')->name('rhs-finance');
Route::get('/finance/chs-finance', 'WebControllers\FinanceController@chsFinance')->name('chs-finance');

/** Despatch  Routes */

Route::get('/despatch', 'WebControllers\DespatchController@home')->name('despatch');
Route::get('/despatch/desp-dashboard', 'WebControllers\DespatchController@despatchDashboard')->name('desp-dashboard');
Route::get('/despatch/desp-dashboard2', 'WebControllers\DespatchController@despatchDashboard2')->name('desp-dashboard2');
Route::get('/despatch/wfshipping', 'WebControllers\DespatchController@wfShipping')->name('wfshipping');
Route::get('/despatch/daily-load-plan', 'WebControllers\DespatchController@dailyLoadPlan')->name('daily-load-plan');
Route::get('/despatch/desp-order-tracking-dashboard', 'WebControllers\DespatchController@despatchOrderTrackingDashboard')->name('desp-order-tracking-dashboard');
Route::get('/despatch/desp-rfd-dashboard', 'WebControllers\DespatchController@despatchRFDDashboard')->name('desp-rfd-dashboard');
Route::get('/despatch/desp-non-prime-stock-dashboard', 'WebControllers\DespatchController@despatchNonPrimeStockDashboard')->name('desp-non-prime-stock-dashboard');

/**
 * P And O
 */
Route::get('/p_and_o', 'WebControllers\PandOController@index')->name('p_and_o');
Route::get('/p_and_o/collected-data-view', 'WebControllers\PandOController@collectedDataView')->name('collected-data-view');
Route::get('/p_and_o/delivery-performance-dashboard-collected', 'WebControllers\PandOController@deliveryPerformanceDashboardCollected')->name('delivery-performance-dashboard-collected');
Route::get('/p_and_o/delivery-performance-dashboard-booked', 'WebControllers\PandOController@deliveryPerformanceDashboardBooked')->name('delivery-performance-dashboard-booked');
Route::get('/p_and_o/p_and_o_log', 'WebControllers\PandOController@log')->name('p_and_o_log');


/** OEE Routes */

Route::get('/oee', 'WebControllers\OEEController@home')->name('oee');

/**
 * External Systems Routes
 */
Route::get('/external-systems', 'WebControllers\ExternalSystemsController@externalSystems')->name('external-systems');



/**
 * Quality Routes
 */
Route::get('/quality', 'WebControllers\QualityController@quality')->name('quality');
Route::get('/quality/nrft-daily', 'WebControllers\QualityController@nrftDaily')->name('nrft-daily');
Route::get('/quality/pipe-quality-tracker', 'WebControllers\QualityController@PipeQualityTracker')->name('pipe-quality-tracker');
Route::get('/quality/pipe-quality-tracker-date-viewer', 'WebControllers\QualityController@PipeQualityTrackerDataViewer')->name('pipe-quality-tracker-data-viewer');
Route::get('/quality/pipe-quality-tracker-rhs', 'WebControllers\QualityController@PipeQualityTrackerRHS')->name('pipe-quality-tracker-rhs');


/**
 * Atlas Energy / Manufacturing Routes
 */
Route::get('atlas-energy/rhs-furnace-energy-prod-monitor', 'WebControllers\AtlasEnergyManufacturingController@RHSFurnaceEnergyProdMonitor')->name('rhs-furnace-energy-prod-monitor');

/**
 *
 * Headless URLS
 */

Route::get('headless/wmmaindashboard123', 'WebControllers\HeadlessChromeController@HeadlessWeldMillDash');
Route::get('headless/rhsmaindashboard123', 'WebControllers\HeadlessChromeController@HeadlessRHSDash');
Route::get('headless/rfmaindashboard123', 'WebControllers\HeadlessChromeController@HeadlessRFDash');
Route::get('headless/slittermaindashboard123', 'WebControllers\HeadlessChromeController@HeadlessSlitterDash');


/**
 * Energy Tick List routes
 */
Route::get('/etl/home', 'WebControllers\ETLHomeController@index')->name('etl-home');
Route::resource('etl_mill', 'WebControllers\EtlMillController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::resource('etl_area', 'WebControllers\ETLAreaController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::resource('etl_asset', 'WebControllers\ETLAssetController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::resource('etl_mill_area', 'WebControllers\ETLMillAreaController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.
Route::resource('etl_mill_area_asset', 'WebControllers\ETLMillAreaAssetController'); // Using the resource() static method of Route, you can create multiple routes to expose multiple actions on the resource.

Route::get('/etl/etl-weld-mill', 'WebControllers\ETLHomeController@weldMill')->name('etl-weld-mill');
Route::get('/etl/etl-casing', 'WebControllers\ETLHomeController@casing')->name('etl-casing');
Route::get('/etl/etl-rhs', 'WebControllers\ETLHomeController@rhs')->name('etl-rhs');
Route::get('/etl/etl-rounds-finishing', 'WebControllers\ETLHomeController@roundsFinishing')->name('etl-rounds-finishing');
Route::get('/etl/production-services', 'WebControllers\ETLHomeController@productionServices')->name('etl-production-services');
Route::get('/etl/engineering', 'WebControllers\ETLHomeController@engineering')->name('etl-engineering');
Route::get('/etl/despatch', 'WebControllers\ETLHomeController@despatch')->name('etl-despatch');
Route::get('/etl/dashboard', 'WebControllers\ETLHomeController@dashboard')->name('etl-dashboard');
Route::get('/etl/edit-etl-submission', 'WebControllers\ETLHistoryController@edit')->name('edit-etl');
Route::get('/etl/etl-man', 'WebControllers\ETLHomeController@manual')->name('etl-man');










Route::get('/data-science-external-links/home', 'WebControllers\DataScienceExternalLinksController@dataScienceExternalLinks')->name('data-science-external-links-home');




Route::resource('cooling-tower-logs', 'WebControllers\CoolingTowerLogsController');

/******
 *
 * ALL API ROUTES
 *
 *
 */




/**
 * USR API Routes.
 */

Route::post('/api/GetUsrData', 'ApiControllers\USRApiController@GetUsrData');



/**
 * Slitter API Routes
 */
Route::post('/api/slitter-dashboard-data', 'ApiControllers\SlitterApiController@GetSlitterDashboardData');

/**
 * ETL API Routes
 */
Route::post('/api/get-etl-dashboard', 'ApiControllers\ETLApiController@GetETLDashboardData');







/**
 * Atlas Energy / Manufacturing API Routes
 */
Route::post('/api/atlas-energy/get-rhs-furnace-energy-prod-monitor-data', 'ApiControllers\AtlasEnergyManufacturingAPIController@GetRHSFurnaceEnergyProdMonitorData');


/**
 * mngr tracking api routes
 */

Route::post('api/SaveMillPenTrackingData', 'ApiControllers\MngrTrackingApiController@SaveMillPenTrackingData')->name('SaveMillPenTrackingData');

/**
 * Weld Mill Api Routes
 */

Route::post('api/GetMacroData', 'ApiControllers\WeldMillApiController@GetMacroData')->name('GetMacroData');

Route::post('/api/GetFurnaceDataAsJSONAfterDateTime', 'ApiControllers\RHSApiController@GetFurnaceStreamChartsWithDateTime')->name('GetFurnaceDataAsJSONAfterDateTime');
Route::post('/api/GetShapeDataAsJSONWithDateTime', 'ApiControllers\RHSApiController@GetShapeDataAsJSONWithDateTime')->name('GetShapeDataAsJSONWithDateTime');


//***
// RHS Furnace dashboard routes
//***
Route::post('/api/GetFurnaceSummaryJSONWithDateTime', 'ApiControllers\RHSApiController@GetFurnaceSummaryJSONWithDateTime')->name('GetFurnaceSummaryJSONWithDateTime');
Route::get('/api/GetLatestRHSFurnaceThroughput', 'ApiControllers\RHSApiController@GetLatestFurnaceThroughput')->name('GetLatestRHSFurnaceThroughput');
Route::post('/api/GetLatestRHSFurnaceFailures', 'ApiControllers\RHSApiController@GetLatestFurnaceFailures')->name('GetLatestRHSFurnaceFailures');
Route::post('/api/GetRHSFurnaceFilterDataLastXHours', 'ApiControllers\RHSApiController@GetFurnaceFilterDataLastXHours')->name('GetRHSFurnaceFilterDataLastXHours');
Route::get('/api/GetLatestRHSFurnaceProductionStatistics', 'ApiControllers\RHSApiController@GetLatestFurnaceProductionStatistics')->name('GetLatestRHSFurnaceProductionStatistics');
Route::get('/api/GetLatestRHSFurnaceTempPerformance', 'ApiControllers\RHSApiController@GetLatestFurnaceTempPerformance')->name('GetLatestRHSFurnaceTempPerformance');
Route::post('/api/GetLatestRHSFurnaceTempPerformanceInRange', 'ApiControllers\RHSApiController@GetLatestFurnaceTempPerformanceInRange')->name('GetLatestRHSFurnaceTempPerformanceInRange');
Route::post('/api/GetFurnaceVisibility', 'ApiControllers\RHSApiController@GetFurnaceVisibility')->name('GetFurnaceVisibility');
Route::post('/api/get-furnace-temp-defect-dashboard-data', 'ApiControllers\RHSApiController@GetFurnaceTempDefectDashboardData');
Route::post('/api/get-rhs-stetch-factor-data', 'ApiControllers\RHSApiController@GetRHSStretchFactorData');

//***
// END RHS Furnace dashboard routes
//***

//**
// RHS Stretch Factor Routes
//****
Route::post('/api/get-furnace-temp-defect-dashboard-data', 'ApiControllers\RHSApiController@GetFurnaceTempDefectDashboardData');



// Casing Furnace dashboard routes
//***
Route::post('/api/GetCasingFurnaceSummaryJSONWithDateTime', 'ApiControllers\RHSApiController@GetFurnaceSummaryJSONWithDateTime')->name('GetFurnaceSummaryJSONWithDateTime');
Route::get('/api/GetLatestCasingFurnaceThroughput', 'ApiControllers\CasingApiController@GetLatestFurnaceThroughput')->name('GetLatestCasingFurnaceThroughput');
Route::post('/api/GetLatestCasingFurnaceFailures', 'ApiControllers\CasingApiController@GetLatestFurnaceFailures');
Route::post('/api/GetCasingFurnaceFilterDataLastXHours', 'ApiControllers\CasingApiController@GetFurnaceFilterDataLastXHours')->name('GetCasingFurnaceFilterDataLastXHours');
Route::get('/api/GetLatestCasingFurnaceProductionStatistics', 'ApiControllers\CasingApiController@GetLatestFurnaceProductionStatistics')->name('GetLatestCasingFurnaceProductionStatistics');
Route::get('/api/GetLatestCasingFurnaceTempPerformance', 'ApiControllers\CasingApiController@GetLatestFurnaceTempPerformance')->name('GetLatestCasingFurnaceTempPerformance');
Route::post('/api/GetLatestCasingFurnaceTempPerformanceInRange', 'ApiControllers\CasingApiController@GetLatestFurnaceTempPerformanceInRange')->name('GetLatestCasingFurnaceTempPerformanceInRange');
Route::post('/api/GetCasingCoolingData', 'ApiControllers\CasingApiController@GetCasingCoolingData')->name('GetCasingCoolingData');
Route::post('/api/GetCasingProductionStats', 'ApiControllers\CasingApiController@GetCasingProductionStats')->name('GetCasingProductionStats');
Route::post('/api/GetCasingFurnaceDashboard', 'ApiControllers\CasingApiController@GetCasingDashboardData');
Route::post('/api/GetFurnaceTempControlData', 'ApiControllers\CasingApiController@GetFurnaceTempControlData');
//***
// END Casing Furnace dashboard routes
//***

//***
// Straightness Aanalysis Routes
//***
Route::post('/api/GetStraightnessDataInRange', 'ApiControllers\RHSApiController@GetStraightnessDataInRange')->name('GetStraightnessDataInRange');
Route::post('/api/GetStraightnessCustomDateRange', 'ApiControllers\RHSApiController@GetStraightnessDataCustomDateRange')->name('GetStraightnessCustomDateRange');
Route::post('/api/GetStraightnessCustomQuery', 'ApiControllers\RHSApiController@GetStraightnessDataCustomQuery')->name('GetStraightnessCustomQuery');
Route::post('/api/getStraightnessDashboardData', 'ApiControllers\RHSApiController@getStraightnessDashboardData');
Route::post('/api/GetStraightnessRejectionByWeekDataCustomQuery', 'ApiControllers\RHSApiController@GetStraightnessRejectionByWeekDataCustomQuery')->name('GetStraightnessRejectionByWeekDataCustomQuery');
Route::get('/api/GetDefaultStraightnessRejectionByWeekData', 'ApiControllers\RHSApiController@GetDefaultStraightnessRejectionByWeekData')->name('GetDefaultStraightnessRejectionByWeekData');
Route::get('/api/GetLiveStraightness', 'ApiControllers\RHSApiController@GetLiveStraightness')->name('GetLiveStraightness');
Route::get('/api/GetLiveBPMStraightness', 'ApiControllers\RHSApiController@GetLiveBPMStraightness')->name('GetLiveBPMStraightness');
Route::get('/api/GetLiveTBStraightness', 'ApiControllers\RHSApiController@GetLiveTBStraightness')->name('GetLiveTBStraightness');
Route::get('/api/GetLiveBPMStraightnessFailures', 'ApiControllers\RHSApiController@GetLiveBPMStraightnessFailures')->name('GetLiveBPMStraightnessFailures');
Route::get('/api/GetLiveTBStraightnessFailures', 'ApiControllers\RHSApiController@GetLiveTBStraightnessFailures')->name('GetLiveBPMStraightnessFailures');
Route::get('/api/GetLiveSectionStraightnessFailures', 'ApiControllers\RHSApiController@GetLiveSectionStraightnessFailures')->name('GetLiveSectionStraightnessFailures');
Route::get('/api/GetLiveStraightnessThroughput', 'ApiControllers\RHSApiController@GetLiveStraightnessThroughput')->name('GetLiveStraightnessThroughput');
Route::get('/api/GetBlockMarkDefectsPerHour', 'ApiControllers\RHSApiController@GetBlockMarkDefectsPerHour')->name('GetBlockMarkDefectsPerHour');
Route::get('/api/GetLastTotalBendTrace', 'ApiControllers\RHSApiController@GetLastTotalBendTrace')->name('GetLastTotalBendTrace');
Route::post('/api/GetRHSQuenchData', 'ApiControllers\RHSApiController@GetRHSQuenchData')->name('GetRHSQuenchData');
Route::post('/api/GetRHSDashboardData', 'ApiControllers\RHSApiController@GetRHSDashboardData')->name('GetRHSDashboardData');
Route::post('/api/GetRHSQuenchSummarySummary', 'ApiControllers\RHSApiController@GetRHSQuenchSummarySummary')->name('GetRHSQuenchSummarySummary');

Route::post('/api/getStraightnessHeatMapData', 'ApiControllers\RHSApiController@getStraightnessHeatMapData');
Route::post('/api/getStraightnessTraceBySectionNo', 'ApiControllers\RHSApiController@getStraightnessTraceBySectionNo');

Route::get('/api/mail', 'ApiControllers\RHSApiController@MailMobile')->name('mail');



/**
/**
 * MngrTrackingAPI Routes
 */
Route::post('/api/GetScrapDGPipeList', 'ApiControllers\MngrTrackingApiController@ScrapDowngradePipeList')->name('GetScrapDGPipeList');
Route::get('/api/GetScrapDGPipeList', 'ApiControllers\MngrTrackingApiController@ScrapDowngradePipeList')->name('GetScrapDGPipeList');
Route::post('/api/getScrapAnalysisData', 'ApiControllers\MngrTrackingApiController@getScrapAnalysisData');
Route::post('/api/GetProductionStats', 'ApiControllers\MngrTrackingApiController@GetProductionStats');


//***
// END Straightness Aanalysis Routes
//***


/**
 * OEE API Routes
 */

/** OEE Routes */

Route::post('/api/GetOEEData', 'APIControllers\OEEApiController@GetOEEData');

/**
 * Pivot Routes
 */
Route::group(['middleware' => ['web']], function () {
    Route::post('/api/GetStockTrackingPivotData', 'ApiControllers\PivotsApiController@GetStockTrackingPivotData')->name('GetStockTrackingPivotData');
});
Route::post('/api/GetCoilPipePivotData', 'ApiControllers\PivotsApiController@GetCoilPipePivotData')->name('GetCoilPipePivotData');
Route::post('/api/GetWeldMillStoppagePivotData', 'ApiControllers\PivotsApiController@GetWeldMillStoppagePivotData')->name('GetWeldMillStoppagePivotData');
Route::post('/api/GetSlitterStoppagePivotData', 'ApiControllers\PivotsApiController@GetSlitterStoppagePivotData')->name('GetSlitterStoppagePivotData');
Route::post('/api/GetStoppagePivotData', 'ApiControllers\PivotsApiController@GetStoppagePivotData')->name('GetStoppagePivotData');
Route::post('/api/GetTrackingWipPivotData', 'ApiControllers\PivotsApiController@GetTrackingWipPivotData')->name('GetTrackingWipPivotData');
Route::post('/api/GetOrderTrackingPivotData', 'ApiControllers\PivotsApiController@GetOrderTrackingPivotData')->name('GetOrderTrackingPivotData');
Route::post('/api/GetStockTrackingPivotData', 'ApiControllers\PivotsApiController@GetStockTrackingPivotData')->name('GetStockTrackingPivotData');
Route::post('/api/GetCoilTrackingPivotData', 'ApiControllers\PivotsApiController@GetCoilTrackingPivotData')->name('GetCoilTrackingPivotData');
Route::post('/api/GetSurplusTrackingPivotData', 'ApiControllers\PivotsApiController@GetSurplusTrackingPivotData')->name('GetSurplusTrackingPivotData');
Route::post('/api/GetNonPrimeTrackingPivotData', 'ApiControllers\PivotsApiController@GetNonPrimeTrackingPivotData')->name('GetNonPrimeTrackingPivotData');
Route::post('/api/GetTestPieceResultPivotData', 'ApiControllers\PivotsApiController@GetTestPieceResultPivotData');
Route::post('/api/GetTestPiecePivotData', 'ApiControllers\PivotsApiController@GetTestPiecePivotData')->name('GetTestPiecePivotData');
Route::post('/api/GetDespatchPivotData', 'ApiControllers\PivotsApiController@GetDespatchPivotData')->name('GetDespatchPivotData');

Route::post('/api/GetPivotConfig', 'ApiControllers\PivotsApiController@GetPivotConfig')->name('GetPivotConfig');

// Pivot config routes
Route::post('/api/pivot-configs/AddNewConfig', 'PivotControllers\PivotApiController@AddNewConfig')->name('AddNewConfig');
Route::post('/api/pivot-configs/UpdateConfig', 'PivotControllers\PivotApiController@UpdateConfig')->name('UpdateConfig');

/**
 * End Pivot Routes
 */


/**
 * WeldMillAPI Routes
 */
Route::post('/api/GetWeldMillMainDashboardData', 'ApiControllers\WeldMillApiController@WeldMillMainDashboardData')->name('GetWeldMillMainDashboardData');
Route::post('/api/GetWeldMillIsStoppedData', 'ApiControllers\WeldMillApiController@WeldMillIsStopped')->name('GetWeldMillIsStoppedData');
Route::post('/api/GetWeldHeadDashboardAveragesAsNVD3Json', 'ApiControllers\WeldMillApiController@GetWeldHeadDashboardAveragesAsNVD3Json')->name('GetWeldHeadDashboardAveragesAsNVD3Json');
Route::post('/api/GetAnnealerDashboardAveragesAsNVD3Json', 'ApiControllers\WeldMillApiController@GetAnnealerDashboardAveragesAsNVD3Json')->name('GetAnnealerDashboardAveragesAsNVD3Json');
Route::post('/api/AddWeldHeadDimensionalVerification', 'ApiControllers\WeldMillApiController@AddWeldHeadDimensionalVerification')->name('AddWeldHeadDimensionalVerification');
Route::get('/api/GetWeldHeadCSV', 'ApiControllers\WeldMillApiController@GetWeldHeadCSV')->name('GetWeldHeadCSV');
Route::get('/api/GetAnnealerCSV', 'ApiControllers\WeldMillApiController@GetAnnealerCSV')->name('GetAnnealerCSV');
Route::post('/api/GetLab1ManualMeasureDataInRange', 'ApiControllers\WeldMillApiController@GetLab1ManualMeasureDataInRange')->name('GetLab1ManualMeasureDataInRange');
Route::post('/api/GetAnnealerPreStartChecksData', 'ApiControllers\WeldMillApiController@GetAnnealerPreStartChecksData')->name('GetAnnealerPreStartChecksData');
Route::post('/api/GetWeldMillStoppageCommentAdderData', 'ApiControllers\WeldMillApiController@GetWeldMillStoppageCommentAdderData')->name('GetWeldMillStoppageCommentAdderData');
Route::post('/api/AddWeldMillStoppageComment', 'ApiControllers\WeldMillApiController@AddWeldMillStoppageComment')->name('AddWeldMillStoppageComment');
Route::post('/api/GetSizingMillSpeed', 'ApiControllers\WeldMillApiController@GetSizingMillSpeed')->name('GetSizingMillSpeed');




/**
 * End WeldMillAPI Routes
 */


Route::post('/api/GetManualMeasureDataInRange', 'ApiControllers\RHSApiController@GetManualMeasureDataInRange')->name('GetManualMeasureDataInRange');
Route::post('/api/GetManMeasureHistoricalAverageData', 'ApiControllers\RHSApiController@GetManMeasureHistoricalAverageData')->name('GetManMeasureHistoricalAverageData');
Route::post('/api/AddRHSChangeLotEntry', 'ApiControllers\RHSApiController@AddChangeLotEntry')->name('AddRHSChangeLotEntry');
Route::get('/api/GetRecentLengthOfSideMeasurements', 'ApiControllers\RHSApiController@GetRecentLengthOfSideMeasurements')->name('GetRecentLengthOfSideMeasurements');



Route::get('/TestAPIGET', 'ApiControllers\RHSApiController@TestAPIGET')->name('TestAPIGET');


Route::get('/test', function () {

    return response('Test API', 200)
        ->header('Content-Type', 'application/json');
});


/**
 * Stock Report APIS
 */
Route::post('/api/UpdateStockValue', 'ApiControllers\StockReportApiController@UpdateStockValue')->name('UpdateStockValue');


/**
 * Rounds Finishing APIS
 */

Route::post('/api/GetEndLaserDataAsNVD3JSON', 'ApiControllers\RoundsFinishingApiController@GetEndLaserDataAsNVD3JSON')->name('GetEndLaserDataAsNVD3JSON');
Route::post('/api/GetRFDashboardData', 'ApiControllers\RoundsFinishingApiController@GetRFDashboardData')->name('GetRFDashboardData');
Route::post('/api/GetRFSummaryData', 'ApiControllers\RoundsFinishingApiController@getEndLaserSummaryData');

/**
 * Data Export Routes
 */
Route::get('/api/WeldMillStoppageDataExport', 'ApiControllers\DataExportApiController@WeldMillStoppageDataExport')->name('WeldMillStoppageDataExport');
Route::get('/api/SlitterStoppageDataExport', 'ApiControllers\DataExportApiController@SlitterStoppageDataExport')->name('SlitterStoppageDataExport');
Route::get('/api/OtherStoppageDataExport', 'ApiControllers\DataExportApiController@OtherStoppageDataExport')->name('OtherStoppageDataExport');
Route::get('/api/rhsStraightnessDataExport', 'ApiControllers\DataExportApiController@rhsStraightnessDataExport')->name('rhsStraightnessDataExport');
Route::get('/api/zumbachLaserDataExport', 'ApiControllers\DataExportApiController@zumbachLaserDataExport')->name('zumbachLaserDataExport');
Route::get('/api/OnsiteReportDataExport', 'ApiControllers\DataExportApiController@onsiteReportDataExport')->name('onsiteReportDataExport');
Route::get('/api/linehistReportDataExport', 'ApiControllers\DataExportApiController@linehistReportDataExport')->name('linehistReportDataExport');
Route::get('/api/varSettingsReportDataExport', 'ApiControllers\DataExportApiController@varSettingsReportDataExport')->name('varSettingsReportDataExport');




/**
 * HRCoilf Controller API
 */
Route::post('/api/GetCoilDetail', 'ApiControllers\HrCoilApiController@GetCoilDetail')->name('GetCoilDetail');
Route::post('/api/GetCoilDetailAndPipeNumbers', 'ApiControllers\HrCoilApiController@GetCoilDetailAndPipeNumbers')->name('GetCoilDetailAndPipeNumbers');
Route::post('/api/GetCoilAndPipeDetail', 'ApiControllers\HrCoilApiController@GetCoilAndPipeDetail')->name('GetCoilAndPipeDetail');


/**
 * Engineering API
 */

Route::post('/api/getEngineeringDashboardData', 'ApiControllers\EngineeringApiController@getStoppageAnalysisDashboardData')->name('getStoppageAnalysisDashboardData');
Route::post('/api/getStopfMachineStoppageAnalysisDashboardData', 'ApiControllers\EngineeringApiController@getStopfMachineStoppageAnalysisDashboardData')->name('getStopfMachineStoppageAnalysisDashboardData');
Route::get('/api/exportHrStopfWeldMillStoppageData', 'ApiControllers\EngineeringApiController@exportHrStopfWeldMillStoppageData')->name('exportHrStopfWeldMillStoppageData');
Route::get('/api/exportStopfStoppageDataByMachineNo', 'ApiControllers\EngineeringApiController@exportStopfStoppageDataByMachineNo')->name('exportStopfStoppageDataByMachineNo');

Route::post('/api/getEngineeringMainDashboardData', 'ApiControllers\EngineeringApiController@GetEngineeringMainDashboardData');

Route::post('/api/getSapNotificationData', 'ApiControllers\EngineeringApiController@getStoppageAnalysisDashboardData')->name('getStoppageAnalysisDashboardData');

/**
 * Macros API
 *
 */

Route::get('/api/exportMacroDataToCSV', 'WebControllers\MacroDataController@exportMacroDataToCSV');

/**
 * Pipe Quality Logs API
 */
Route::post('/api/getPipeQualityLogs', 'ApiControllers\PipeQualityLogsApiController@GetPipeQualityLogsData')->name('GetPipeQualityLogsData');
Route::get('/api/exportPipeQualityLogDataToCSV', 'WebControllers\PipeQualityLogsController@exportPipeQualityLogDataToCSV')->name('exportPipeQualityLogDataToCSV');


/**
 * TPM Routes API
 */
Route::post('/api/test-result-distribution', 'ApiControllers\TestPieceManagementApiController@testPieceResultDistribution');


/**
 * Transf API Routes
 */

Route::post('/api/GetPipeDetailToPositionByDate', 'ApiControllers\TransfApiController@getPipeDetailToPositionByDate');

/** Despatch API Routes */

Route::post('/api/getDespDashboardData', 'ApiControllers\DespatchApiController@getDespatchDashboardData');
Route::post('/api/getSingleCustomerIntervalStackedBarJson', 'ApiControllers\DespatchApiController@getSingleCustomerIntervalStackedBarJson');
Route::post('/api/getcustomerTonnesByHomeExportBarChartJson', 'ApiControllers\DespatchApiController@getcustomerTonnesByHomeExportBarChartJson');
Route::post('/api/getcustomerTonnesByBusinessBarChartJson', 'ApiControllers\DespatchApiController@getcustomerTonnesByBusinessBarChartJson');
Route::post('/api/getDailyLoadPlanData', 'ApiControllers\DespatchApiController@getDailyLoadPlanData');
Route::post('/api/getDespatchOrderTrackingDashboardData', 'ApiControllers\DespatchApiController@getDespatchOrderTrackingDashboardData');

/** MOC API Routes */
Route::post('/api/saveInsignificantMocAsDraft', 'WebControllers\MOCApiController@saveInsignificantMocAsDraft');

/** WM Gauge Change Routes */
Route::post('/api/GetGaugeChangeByCoilWeek ', 'ApiControllers\WMGaugeChangeApiController@GetGaugeChangeByCoilWeek');
Route::post('/api/GetGaugeChangeData ', 'ApiControllers\WMGaugeChangeApiController@GetGaugeChangeData');

/**
 * P And O API Routes
 */
Route::get('/api/updateRecordComments', 'ApiControllers\PandOApiController@updateRecordComments');

Route::post('/api/getCollectedDashboardData', 'ApiControllers\PandOApiController@getCollectedDashboardData');
Route::post('/api/getBookedDashboardData', 'ApiControllers\PandOApiController@getBookedDashboardData');

/**
 * Furnace Temp Defect Action
 */
Route::post('/api/saveFurnaceTempDefectAction', 'ApiControllers\RHSApiController@saveFurnaceTempDefectAction');
Route::post('/api/getFurnaceTempDefectAction', 'ApiControllers\RHSApiController@getFurnaceTempDefectAction');




/**
 * Quality API Routes.
 */
Route::post('/api/getPipeQualityTrackerData', 'ApiControllers\QualityApiController@GetPipeQualityTrackerData');
Route::post('/api/getPipeQualityTrackerDataRHS', 'ApiControllers\QualityApiController@GetPipeQualityTrackerDataRHS');

Route::post('/api/setPipeQualityNonSerious', 'ApiControllers\QualityApiController@SetNonSeriousIndication');
Route::post('/api/setPipeQualityInspectedFlag', 'ApiControllers\QualityApiController@setPipeQualityInspectedFlag');

/**
 * PLC  API Routes.
 */

Route::get('/api/GetWeldPowerLastXMins', 'ApiControllers\PLCApiController@GetWeldPowerLastXMins');
Route::post('/api/GetWeldPowerLastXMins', 'ApiControllers\PLCApiController@GetWeldPowerLastXMins');



/**
 * ETL Routes
 */

Route::post('/api/ManualETLInsert', 'ApiControllers\ETLApiController@ManualETLInsert');
