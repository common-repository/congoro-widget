<?php
if(!defined('ABSPATH')){
	exit;
} // Exit if accessed directly
?>
<div style="overflow: hidden;clear:both">
	<?php echo $warning_html; ?>
</div>
<div class="wrap congoro-widget-container">

	<div class="right-panel">
		<div class="widget-configuration-container">
			<?php
			$widget_number = 1;
			foreach($active_widgets as $widget){
				$widget = (array)$widget;

				if($widget['widgetCode']==="" &&
				   $widget['fontSize']===null &&
				   $widget['displayType'] === null &&
				   $widget['widgetId']===null){
					continue;
				}


				if(!isset($widget['widgetId'])){
					$widget = $default_setting;
				}

				if(empty($widget['fontName'])){
					$widget['fontName'] = 'a';
				}
				?>
				<div class="widget-configuration animated fadeIn">
					<form action="<?php echo str_replace('%7E','~',$_SERVER['REQUEST_URI']); ?>"
					      name="acc_content_form[]"
					      class="widget-form">

						<input name="widgetId" class="widgetId" type="hidden"
						       value="<?php echo $widget['widgetId'] ?>"/>

						<div class="content-loader animated fadeIn">
							<svg class="circular" height="35" width="35">
								<circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="4"
								        stroke-miterlimit="10"/>
							</svg>
						</div>


						<div class="title-bar">
							<h2 class="congoro-widget-title widget-first-title">ویجت <?php echo $widget_number++; ?>
							</h2>
							<div class="remove-widget" title="حذف">
								X
							</div>
						</div>

						<textarea name="congoro_widget_code"
						          style="display: none"><?php echo congoroWidgetFunctions::stripBackslashes($widget['widgetCode']); ?></textarea>

						<div class="options-container">
							<div class="customize-option">
								<div class="title">نوع ویجت:</div>
								<p class="widget-titles">
									<label>
										<input name="widgetType" type="radio"value="0"
										       onclick="congoroWidget_generateWidgetSample(jQuery(this).closest('.widget-configuration'))" <?php echo $widget['widgetType']==0|| !$widget['widgetType']?'checked':'' ?>/>
										همگن
									</label>
								</p>
								<p class="widget-titles" style="display: none">
									<label for="widget-type-1">
										<input name="widgetType" type="radio"value="1"
										       onclick="congoroWidget_generateWidgetSample(jQuery(this).closest('.widget-configuration'))" <?php echo $widget['widgetType']==1?'checked':'' ?>/>
										فید خبری
									</label>
								</p>

								<p class="widget-titles">
									<label>
										<input name="widgetType" type="radio" value="2"
										       onclick="congoroWidget_generateWidgetSample(jQuery(this).closest('.widget-configuration'))" <?php echo $widget['widgetType']==2?'checked':'' ?>/>
											ثابت
									</label>
								</p>
							</div>

							<div class="customize-option recom-length <?php echo $widget['widgetType']==2?'hide':''?>">
								<div class="congoro-customize-items-title">تعداد محتوای پیشنهادی:</div>
								<p class="content-length">
									<label>
										<input name="itemsCount" type="radio" value="b"
										       onclick="congoroWidget_generateWidgetSample(jQuery(this).closest('.widget-configuration'))" <?php echo $widget['itemsCount']==='b'?'checked':'' ?>/>
										۳
									</label>
								</p>
								<p class="content-length">
									<label>
										<input name="itemsCount" type="radio" value="a"
										       onclick="congoroWidget_generateWidgetSample(jQuery(this).closest('.widget-configuration'))" <?php echo $widget['itemsCount']==='a'?'checked':'' ?>/>
										۴ </label>
								</p>
								<p class="content-length">
									<label>
										<input name="itemsCount" type="radio" value="c"
										       onclick="congoroWidget_generateWidgetSample(jQuery(this).closest('.widget-configuration'))" <?php echo $widget['itemsCount']==='c'?'checked':'' ?>/>
										۶ </label>
								</p>
								<p class="content-length">
									<label>
										<input name="itemsCount" type="radio" value="d"
										       onclick="congoroWidget_generateWidgetSample(jQuery(this).closest('.widget-configuration'))" <?php echo $widget['itemsCount']==='d'?'checked':'' ?>/>
										۸</label>
								</p>
							</div>

							<div class="customize-option congoro-font-family">
								<div class="title" style="margin-bottom: 0">انتخاب فونت:</div>

								<select class="font-family-select" name="fontFamily"
								        onchange="congoroWidget_generateWidgetSample(jQuery(this).closest('.widget-configuration'))">
									<option data-image="http://congoro.com/assets/img/font-samples/iransans.png"
									        value="a" <?php echo $widget['fontName']==='a'?'selected':'' ?>> (ایران سنس)
									</option>
									<option data-image="http://congoro.com/assets/img/font-samples/vaziri.png"
									        value="b" <?php echo $widget['fontName']==='b'?'selected':'' ?>> (وزیری)
									</option>
									<option data-image="http://congoro.com/assets/img/font-samples/iranyekan.png"
									        value="c" <?php echo $widget['fontName']==='c'?'selected':'' ?>> (ایران
										یکان)
									</option>
									<option data-image="http://congoro.com/assets/img/font-samples/ganjnameh.png"
									        value="d" <?php echo $widget['fontName']==='d'?'selected':'' ?>> (گنج نامه)
									</option>
									<option data-image="http://congoro.com/assets/img/font-samples/shabnam.png"
									        value="e" <?php echo $widget['fontName']==='e'?'selected':'' ?>> (شبنم)
									</option>
									<option data-image="http://congoro.com/assets/img/font-samples/nika.png"
									        value="f" <?php echo $widget['fontName']==='f'?'selected':'' ?>> (نیکا)
									</option>
								</select>

							</div>

							<div class="customize-option">
								<div class="congoro-customize-items-title" style="margin-bottom: 0">اندازه فونت:</div>
								<p class="range-field" id="font-size">
								<div class="font-size-range-value"
								     style="font-size:<?php echo(intval($widget['fontSize'])+3); ?>px">
									<?php echo $widget['fontSize'] ?>
									px
								</div>
								<input type="range" class="font-size-range" min="13" max="17" step="1"
								       value="<?php echo $widget['fontSize'] ?>" name="fontSize"
								       onclick="congoroWidget_generateWidgetSample(jQuery(this).closest('.widget-configuration'))">
								</p>
							</div>

							<div class="customize-option image-type-option">
								<div class="title"> شکل تصاویر:</div>
								<p class="widget-titles">
									<label>
									<input name="imageType" type="radio" value="1"
									       onclick="congoroWidget_generateWidgetSample(jQuery(this).closest('.widget-configuration'))" <?php echo $widget['imageType']==1?'checked':'' ?>/>
									چهارگوش
									</label>
								</p>
								<p class="widget-titles">
									<label>
									<input name="imageType" type="radio" value="0"
									       onclick="congoroWidget_generateWidgetSample(jQuery(this).closest('.widget-configuration'))" <?php echo $widget['imageType']==0?'checked':'' ?>/>
									گردالی
									</label>
								</p>
								<p class="widget-titles">
									<label>
									<input name="imageType" type="radio" value="2"
									       onclick="congoroWidget_generateWidgetSample(jQuery(this).closest('.widget-configuration'))" <?php echo $widget['imageType']==2?'checked':'' ?>/>
									گوشه گرد
									</label>
								</p>
							</div>

							<div class="customize-option widget-title <?php echo $widget['widgetType']==2?'hide':''?>" style="height:150px">
								<div class="congoro-customize-items-title">عنوان ویجت:</div>
								<p class="widget-titles">
									<label>
										<input name="widgetTitle" type="radio" value="a"
										       onclick="congoroWidget_generateWidgetSample(jQuery(this).closest('.widget-configuration'))" <?php echo $widget['widgetTitle']==='a'?'checked':'' ?>/>

										مقالات مرتبط
									</label>
								</p>
								<p class="widget-titles">
									<label>
										<input name="widgetTitle" type="radio" value="b"
										       onclick="congoroWidget_generateWidgetSample(jQuery(this).closest('.widget-configuration'))" <?php echo $widget['widgetTitle']==='b'?'checked':'' ?>/>

										مطالب مرتبط
									</label>
								</p>
								<p class="widget-titles">
									<label>
										<input name="widgetTitle" type="radio" value="c"
										       onclick="congoroWidget_generateWidgetSample(jQuery(this).closest('.widget-configuration'))" <?php echo $widget['widgetTitle']==='c'?'checked':'' ?>/>

										بیشتر بخوانید
									</label>
								</p>
								<p class="widget-titles">
									<label>
										<input name="widgetTitle" type="radio" value="d"
										       onclick="congoroWidget_generateWidgetSample(jQuery(this).closest('.widget-configuration'))" <?php echo $widget['widgetTitle']==='d'?'checked':'' ?>/>

										مطالب پیشنهادی
									</label>
								</p>

								<p class="widget-titles">
									<label>
										<input name="widgetTitle" type="radio" value="e"
										       onclick="congoroWidget_generateWidgetSample(jQuery(this).closest('.widget-configuration'))" <?php echo $widget['widgetTitle']==='e'?'checked':'' ?>/>
										بدون عنوان
									</label>
								</p>
							</div>

							<div class="customize-option colorset <?php echo $widget['widgetType']!=2?'hide':''?>">
								<div class="title">رنگ زمینه:</div>
								<div>
									<select name="colorSet" class="colorsetSelect form-control"
									        onclick="congoroWidget_generateWidgetSample(jQuery(this).closest('.widget-configuration'))">
										<option style="background-color: black" data-image="http://congoro.com/assets/img/colorsets/black.png" value="a" <?php echo $widget['colorSet']==='a'?'selected':'' ?>></option>
										<option style="background-color: #00a18b" data-image="http://congoro.com/assets/img/colorsets/greenblue.png" value="b" <?php echo $widget['colorSet']==='b'?'selected':'' ?>></option>
										<option style="background-color: #e0e0e0" data-image="http://congoro.com/assets/img/colorsets/gray.png" value="c" <?php echo $widget['colorSet']==='c'?'selected':'' ?>></option>
										<option style="background-color: #dd2c00" data-image="http://congoro.com/assets/img/colorsets/darkorange.png" value="d" <?php echo $widget['colorSet']==='d'?'selected':'' ?>></option>
										<option style="background-color: #4e342e" data-image="http://congoro.com/assets/img/colorsets/darkbrown.png" value="e" <?php echo $widget['colorSet']==='e'?'selected':'' ?>></option>
										<option style="background-color: #64dd17" data-image="http://congoro.com/assets/img/colorsets/lightgreen.png" value="f" <?php echo $widget['colorSet']==='f'?'selected':'' ?>></option>
										<option style="background-color: #00b0ff" data-image="http://congoro.com/assets/img/colorsets/lightblue.png" value="g" <?php echo $widget['colorSet']==='g'?'selected':'' ?>></option>
										<option style="background-color: #0d47a1" data-image="http://congoro.com/assets/img/colorsets/darkblue.png" value="h" <?php echo $widget['colorSet']==='h'?'selected':'' ?>></option>
										<option style="background-color: #616161" data-image="http://congoro.com/assets/img/colorsets/darkgray.png" value="i" <?php echo $widget['colorSet']==='i'?'selected':'' ?>></option>
										<option style="background-color: #546e7a" data-image="http://congoro.com/assets/img/colorsets/darkbluegray.png" value="j" <?php echo $widget['colorSet']==='j'?'selected':'' ?>></option>
										<option style="background-color: #d50000" data-image="http://congoro.com/assets/img/colorsets/darkred.png" value="k" <?php echo $widget['colorSet']==='k'?'selected':'' ?>></option>
										<option style="background-color: #880e4f" data-image="http://congoro.com/assets/img/colorsets/darkpink.png" value="l" <?php echo $widget['colorSet']==='l'?'selected':'' ?>></option>
										<option style="background-color: #4a148c" data-image="http://congoro.com/assets/img/colorsets/darkpurple.png" value="m" <?php echo $widget['colorSet']==='m'?'selected':'' ?>></option>
										<option style="background-color: #006064" data-image="http://congoro.com/assets/img/colorsets/darkcyan.png" value="n" <?php echo $widget['colorSet']==='n'?'selected':'' ?>></option>
										<option style="background-color: #827717" data-image="http://congoro.com/assets/img/colorsets/darklime.png" value="o" <?php echo $widget['colorSet']==='o'?'selected':'' ?>></option>
									</select>
								</div>
							</div>


							<div class="customize-option colorset <?php echo $widget['widgetType']!=2?'hide':'';?>">
								<div class="title">محل قرارگیری:</div>
								<div>
									<select class="form-control widgetPositionSelect" onchange="congoroWidget_generateWidgetSample(jQuery(this).closest('.widget-configuration'))"
									        name="widgetPosition">
										<option value="b" <?php echo $widget['widgetPosition']==='b'?'selected':'' ?>>پایین</option>
										<option value="r" <?php echo $widget['widgetPosition']==='r'?'selected':'' ?>>سمت راست</option>
										<option value="l" <?php echo $widget['widgetPosition']==='l'?'selected':'' ?>>سمت چپ</option>
									</select>
								</div>
							</div>
						</div>

						<div class="customize-option widget-position-type <?php echo $widget['widgetType']==2?'hide':'';?>" style="height: auto;width:93%;float: none;">
							<div class="congoro-customize-items-title">محل قرارگیری ویجت کانگورو را انتخاب کنید:</div>
							<p>

								<label>
									<input name="displayType" type="radio" value="content"
									       onclick="congoroWidget_showTip(false,this)"
										<?php echo $widget['displayType']==='content'?'checked':'' ?>/>
									نمایش در زیر محتوای پست

								</label>
							</p>
							<p>

								<label>
									<input name="displayType" type="radio" value="widget"
									       onclick="congoroWidget_showTip('widget',this);"
										<?php echo $widget['displayType']==='widget'?'checked':'' ?>/>
									فقط بصورت ابزارک
								</label>

							<div class="add-widget-tip"
							     style="display: <?php echo $widget['displayType']==='widget'?'block':'none' ?>;">
								<b>راهنمای افزودن ابزارک: </b>

								با انتخاب این گزینه به مسیر
								<a href="./widgets.php" target="_blank">مسیر پیشخوان » نمایش » ابزارک ها</a>
								مراجعه کنید و کانگورو را در هر بخشی از قالب خود که تمایل دارید قرار دهید.
							</div>
							</p>

							<p>

								<label>
									<input name="displayType" type="radio" value="afterNthParagraph"
									       onclick="congoroWidget_showTip('after-paragraph',this);"
										<?php echo $widget['displayType']==='afterNthParagraph'?'checked':'' ?>/>

									نمایش بعد از پاراگراف <input type="text" name="nthParagraphValue"
									                             value="<?php echo $widget['nthParagraphValue'] ?>"/>
								</label>

							<div class="after-paragraph-tip"
							     style="display: <?php echo $widget['displayType']==='afterNthParagraph'?'block':'none' ?>;">
								<b>راهنما: </b>

								با انتخاب این گزینه و وارد کردن عدد پاراگراف، ویجت کانگورو بعد از پاراگراف وارد شده در
								صفحه پست نمایش داده خواهد شد.
							</div>
							</p>
						</div>

						<input type="hidden" name="acc_content_form_submit" value="Y">
						<p class="submit" style="text-align: right">
							<input type="submit" class="button button-primary"
							       name="Submit" value="ذخیره و نمایش"/>
						</p>

					</form>
				</div>
				<?php
			}
			?>
		</div>


		<p class="submit" style="text-align: right">
			<a class="button button-default clone-widget-container">+ افزودن ویجت</a>
		</p>
	</div>


	<div class="left-panel">
		<h2 class="congoro-widget-title">
			<img src="http://congoro.com/panel/assets/img/logo-top.png" class="logo"/>
			کانگورو
		</h2>

		<div class="customize-option" style="height: auto;width: 100%;float: none;font-family:tahoma">
			<p class="">
				اگر می خواهید پست های وبلاگ خود یا محصولات وبسایت تان را معرفی کنید می توانید به عنوان آگهی دهنده در
				کانگورو از خدمات استفاده کنید.
				<br/>
				<br/>
				<a href="http://congoro.com/panel" class="button button-default" target="_blank">پنل کاربران</a>
				<a href="http://congoro.com" class="button button-default" target="_blank">سایت اصلی</a>
				<a href="http://congoro.com/faq" class="button button-default" target="_blank">سوالات متداول</a>
			</p>
		</div>
		<div class="customize-option"
		     style="height: auto;width: 100%;float: none;font-family:tahoma;    margin-top: 5px;">
			<h3 class="congoro-warnings-title"><span class="dashicons dashicons-warning"></span> نکات مهم</h3>
			<ul>
				<li>
					در صورتی که از پلاگین های caching مثل w3 total cache استفاده می کنید توجه کنید ممکن است این نوع
					پلاگین ها با minify کردن کدهای جاوااسکریپت در نمایش صحیح ویجت کانگورو خلل ایجاد کنند.
				</li>
			</ul>
		</div>
	</div>

</div>