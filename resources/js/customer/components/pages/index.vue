<template>
    <div>
        <section class="slide1">
		<div class="wrap-slick1">
			<div class="slick1">
				<div class="item-slick1 item1-slick1" style="background-image: url(images/banner.jpeg);">
					<div class="wrap-content-slide1 sizefull flex-col-c-m p-l-15 p-r-15 p-t-150 p-b-170">
						<span class="caption1-slide1 m-text1 t-center animated visible-false m-b-15" data-appear="fadeInDown">
							Women Collection 2018
						</span>

						<h2 class="caption2-slide1 xl-text1 t-center animated visible-false m-b-37" data-appear="fadeInUp">
							New arrivals
						</h2>

						<div class="wrap-btn-slide1 w-size1 animated visible-false" data-appear="zoomIn">
							<!-- Button -->
							<a href="product.html" class="flex-c-m size2 bo-rad-23 s-text2 bgwhite hov1 trans-0-4">
								Shop Now
							</a>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>

	<!-- Banner -->
	<section class="banner bgwhite p-t-40 p-b-40">
		<div class="container">
			<div class="row">
				<div class="col-sm-10 col-md-8 col-lg-4 m-l-r-auto">
					<!-- block1 -->
					<div class="block1 hov-img-zoom pos-relative m-b-30">
						<img src="images/tapvan.jpg" alt="IMG-BENNER" width="370" height="480">

						<div class="block1-wrapbtn w-size2">
							<!-- Button -->
							<a href="/tap-van" class="flex-c-m size2 m-text2 bg3 hov1 trans-0-4">
								TẠP VĂN
							</a>
						</div>
					</div>

					<!-- block1 -->
					<div class="block1 hov-img-zoom pos-relative m-b-30">
						<img src="images/tieuthuyet.jpg" alt="IMG-BENNER" width="370" height="340">

						<div class="block1-wrapbtn w-size2">
							<!-- Button -->
							<a href="/tieu-thuyet" class="flex-c-m size2 m-text2 bg3 hov1 trans-0-4">
								TIỂU THUYẾT
							</a>
						</div>
					</div>
				</div>

				<div class="col-sm-10 col-md-8 col-lg-4 m-l-r-auto">
					<!-- block1 -->
					<div class="block1 hov-img-zoom pos-relative m-b-30">
						<img src="images/truyentranh.jpg" alt="IMG-BENNER" width="370" height="340">

						<div class="block1-wrapbtn w-size2">
							<!-- Button -->
							<a href="/truyen-tranh" class="flex-c-m size2 m-text2 bg3 hov1 trans-0-4">
								Truyện Tranh
							</a>
						</div>
					</div>

					<!-- block1 -->
					<div class="block1 hov-img-zoom pos-relative m-b-30">
						<img src="images/truyendai.jpg" alt="IMG-BENNER" width="370" height="480">

						<div class="block1-wrapbtn w-size2">
							<!-- Button -->
							<a href="/truyen-dai" class="flex-c-m size2 m-text2 bg3 hov1 trans-0-4">
								Truyện Dài
							</a>
						</div>
					</div>
				</div>

				<div class="col-sm-10 col-md-8 col-lg-4 m-l-r-auto">
					<!-- block1 -->
					<div class="block1 hov-img-zoom pos-relative m-b-30">
						<img src="images/truyenngan.jpg" alt="IMG-BENNER" width="370" height="480">

						<div class="block1-wrapbtn w-size2">
							<!-- Button -->
							<a href="/truyen-ngan" class="flex-c-m size2 m-text2 bg3 hov1 trans-0-4">
								Truyện Ngắn
							</a>
						</div>
					</div>

					<!-- block2 -->
					<div class="block2 wrap-pic-w pos-relative m-b-30">
						<img src="images/icons/bg-01.jpg" alt="IMG">

						<div class="block2-content sizefull ab-t-l flex-col-c-m">
							<h4 class="m-text4 t-center w-size3 p-b-8">
								Sign up & get 20% off
							</h4>

							<p class="t-center w-size4">
								Be the frist to know about the latest fashion news and get exclu-sive offers
							</p>

							<div class="w-size2 p-t-25">
								<!-- Button -->
								<a href="#" class="flex-c-m size2 bg4 bo-rad-23 hov1 m-text3 trans-0-4">
									Sign Up
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- New Product -->
	<section class="newproduct bgwhite p-t-45 p-b-105">
		<div class="container">
			<div class="sec-title p-b-60">
				<h3 class="m-text5 t-center">
					SÁCH MUA NHIỀU
				</h3>
			</div>

			<!-- Slide2 -->
			<div class="row">
				<div v-for="item in popular_books" :key="item.id" class="col-sm-12 col-md-6 col-lg-3 p-b-50">
					<!-- Block2 -->
					<div class="block2">
						<div class="block2-img wrap-pic-w of-hidden pos-relative">
							<img :src="'/storage/product/' + item.slug + '.jpg'" :alt="item.name" width="270" height="370">

							<div class="block2-overlay trans-0-4">
								<a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4">
									<i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>
									<i class="icon-wishlist icon_heart dis-none" aria-hidden="true"></i>
								</a>

								<div class="block2-btn-addcart w-size1 trans-0-4">
									<!-- Button -->
									<button @click="addCart(item)" class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4">
										Add to Cart
									</button>
								</div>
							</div>
						</div>

						<div class="block2-txt p-t-20">
							<a href="product-detail.html" class="block2-name dis-block s-text3 p-b-5">
								{{item.name}}
							</a>

							<span class="block2-price m-text6 p-r-5">
								{{item.price}}đ
							</span>
						</div>
					</div>
				</div>
			</div>

		</div>
	</section>

	<section class="newproduct bgwhite p-t-45 p-b-105">
		<div class="container">
			<div class="sec-title p-b-60">
				<h3 class="m-text5 t-center">
					SÁCH MỚI
				</h3>
			</div>

			<!-- Slide2 -->
			<div class="row">
				<div v-for="item in latest_books" :key="item.id" class="col-sm-12 col-md-6 col-lg-3 p-b-50">
					<!-- Block2 -->
					<div class="block2">
						<div class="block2-img wrap-pic-w of-hidden pos-relative block2-labelnew">
							<img :src="'/storage/product/' + item.slug + '.jpg'" :alt="item.name" width="270" height="370">

							<div class="block2-overlay trans-0-4">
								<a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4">
									<i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>
									<i class="icon-wishlist icon_heart dis-none" aria-hidden="true"></i>
								</a>

								<div class="block2-btn-addcart w-size1 trans-0-4">
									<!-- Button -->
									<button @click="addCart(item)" class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4">
										Add to Cart
									</button>
								</div>
							</div>
						</div>

						<div class="block2-txt p-t-20">
							<a href="product-detail.html" class="block2-name dis-block s-text3 p-b-5">
								{{item.name}}
							</a>

							<span class="block2-price m-text6 p-r-5">
								{{item.price}}đ
							</span>
						</div>
					</div>
				</div>
			</div>

		</div>
	</section>

	<!-- Shipping -->
	<section class="shipping bgwhite p-t-62 p-b-46">
		<div class="flex-w p-l-15 p-r-15">
			<div class="flex-col-c w-size5 p-l-15 p-r-15 p-t-16 p-b-15 respon1">
				<h4 class="m-text12 t-center">
					Free Delivery Worldwide
				</h4>

				<a href="#" class="s-text11 t-center">
					Click here for more info
				</a>
			</div>

			<div class="flex-col-c w-size5 p-l-15 p-r-15 p-t-16 p-b-15 bo2 respon2">
				<h4 class="m-text12 t-center">
					30 Days Return
				</h4>

				<span class="s-text11 t-center">
					Simply return it within 30 days for an exchange.
				</span>
			</div>

			<div class="flex-col-c w-size5 p-l-15 p-r-15 p-t-16 p-b-15 respon1">
				<h4 class="m-text12 t-center">
					Store Opening
				</h4>

				<span class="s-text11 t-center">
					Shop open from Monday to Sunday
				</span>
			</div>
		</div>
	</section>
    </div>
</template>
<script>
import { EventBus } from '../../../event.js'
import 'slick-carousel';
import 'animsition';
export default {
	data () {
		return {
			popular_books: [],
			latest_books: [],
		}
	},
	mounted () {
		// Get sach
		var app = this;
		axios.get('/book/popular').then(repsonse => {
			app.popular_books = repsonse.data;
		}).catch(errors => {
			ErrorHelper.error(errors);
		});
		axios.get('/book/latest').then(response => {
			app.latest_books = response.data;
		}).catch(errors => {
			ErrorHelper.error(errors);
		});
	},
	methods: {
		addCart(book) {
			EventBus.$emit('addCart', book);
		}
	}
}
</script>
