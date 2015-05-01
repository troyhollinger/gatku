@extends('layouts.master')

@section('title')
Admin
@stop

@section('content')


	<div class="admin-container" ng-controller="AdminController">

		<h1>Admin</h1>
		
		<div class="admin-navigation-container">
			<div class="admin-navigation-tab" ng-click="show('orders')" ng-class="{'selected' : showOrders}">Orders</div>
			<div class="admin-navigation-tab" ng-click="show('products')" ng-class="{'selected' : showProducts}">Products</div>
			<div class="admin-navigation-tab" ng-click="show('you')" ng-class="{'selected' : showYou}">You</div>
			<div class="admin-navigation-tab" ng-click="show('videos')" ng-class="{'selected' : showVideos}">Videos</div>
			<div class="clear"></div>
		</div>

		<div class="admin-section" ng-show="showOrders" ng-cloak>
			<h2>Orders</h2>

			<table class="admin-orders-table">

				<tr>
					<th>Name</th>
					<th>Products</th>
					<th>Actions</th>
					<th>Date</th>
				</tr>

				<tr ng-repeat="order in orders">
					<td>@{{ order.customer.fullName }}</td>
					<td>
						<ul>
							<li ng-repeat="item in order.items">
								@{{ item.product.name }}
								<ul class="admin-order-addons-list">
									<li ng-repeat="addon in item.addons">
										@{{ addon.product.name }}
									</li>
								</ul>
							</li>
						</ul>
					</td>
					<td><div class="button info-bg">Print Label</div></td>
					<td>@{{ order.createdAtHuman }}</td>
				</tr>



			</table>

		</div>

		<div class="admin-section" ng-if="showProducts" ng-cloak>
			
			<div class="admin-sub-section">

				<div class="button success-bg" ng-hide="editState" ng-click="createProduct()">Create Product</div>
				<div class="button success-bg" ng-show="editState && editingNew" ng-click="saveProduct();">Save</div>
				<div class="button success-bg" ng-show="editState && editingNew === false" ng-click="updateProduct();">Update</div>
				<div class="button error-bg" ng-show="editState" ng-click="reset();">Cancel</div>
				<span ng-show="editState" class="edit-indicator">Editing Product</span>

				<form class="new-product-form" ng-show="editState" ng-cloak>

					<label>Product Type</label>
					<select ng-options="type.id as type.name for type in types" ng-model="newProduct.typeId"></select>
					<br>
					<label>Name</label>
					<input type="text" ng-model="newProduct.name">

					<label>Short Name</label>
					<input type="text" ng-model="newProduct.shortName">

					<label>Slug</label>
					<input type="text" ng-model="newProduct.slug">

					<label>Description</label>
					<textarea ng-model="newProduct.description"></textarea>

					<label>Meta Description</label>
					<input type="text" ng-model="newProduct.metaDescription">

					<label>Length</label>
					<input type="text" ng-model="newProduct.length">

					<label>Price</label>
					<input type="number" ng-model="newProduct.price">

					<label>Addons</label>
					<div class="new-product-checkbox-container" ng-repeat="addon in newProduct.addonSelection" ng-if="editState">
						<input type="checkbox" ng-model="addon.isAddon">&nbsp;<span class="uppercase">@{{ addon.name }}</span>
					</div>
					

					<label>Attached Image</label>
					<div class="upload-field" ng-style="{'background-image':'url(' + newProduct.attachedImage + ')'}">
						<i class="fa fa-image" ng-hide="newProduct.attachedImage"></i>
						<input type="text" ng-model="newProduct.attachedImage" class="image-path-storage-input">
						<input type="file" ng-file-drop ng-file-select="upload($files, 'attachedImage')">
					</div>
					
					<label>Detached Image</label>
					<div class="upload-field" ng-style="{'background-image':'url(' + newProduct.detachedImage + ')'}">
						<i class="fa fa-image" ng-hide="newProduct.detachedImage"></i>
						<input type="text" ng-model="newProduct.detachedImage" class="image-path-storage-input">
						<input type="file" ng-file-select="upload($files, 'detachedImage')">
					</div>

					<label>Thumb</label>
					<div class="upload-field" ng-style="{'background-image':'url(' + newProduct.thumb + ')'}">
						<i class="fa fa-image" ng-hide="newProduct.thumb"></i>
						<input type="text" ng-model="newProduct.thumb" class="image-path-storage-input">
						<input type="file" ng-file-select="upload($files, 'thumb')">
					</div>

					<label>Maneuverability</label>
					<input type="text" ng-model="newProduct.maneuverability">

					<label>Trajectory</label>
					<input type="text" ng-model="newProduct.trajectory">

					<label>Balance</label>
					<input type="text" ng-model="newProduct.balance">

					<label>Stealth</label>
					<input type="text" ng-model="newProduct.stealth"> 
				</form>

				<div class="button success-bg" ng-show="editState && editingNew" ng-click="saveProduct();">Save</div>
				<div class="button success-bg" ng-show="editState && editingNew === false" ng-click="updateProduct();">Update</div>
				<div class="button error-bg" ng-show="editState" ng-click="reset();">Cancel</div>
				<span ng-show="editState" class="edit-indicator">Editing Product</span>

			</div>

			<div class="admin-sub-section" ng-hide="editState">

				<h2>Products</h2>

				<table class="admin-products-table">
					<tr>
						<th>Name</th>
						<th>Type</th>
						<th>Actions (hover)</th>
					</tr>
					<tr ng-repeat="product in products">
						<td class="bold uppercase">@{{ product.name }}</td>
						<td class="faded">@{{ product.type.name }}</td>
						<td>
							<a href="/product/@{{ product.slug }}" target="_blank"><div class="button info-bg">View</div></a>
							<div class="button info-bg" ng-click="editProduct(product)">Edit</div>
							<div class="button error-bg">Delete</div>
						</td>
					</tr>
				</table>

			</div>

		</div>

		<div class="admin-section" ng-show="showYou" ng-cloak>
			<h2>You</h2>

			<div class="admin-sub-section">

				<div class="button success-bg" ng-hide="editState" ng-file-select="uploadYouImage($files)">Upload New</div>
				<span ng-show="editState" class="edit-indicator">Editing You Image</span>

				<div class="admin-you-image-staging" ng-show="editState">
					<div class="upload-field" ng-style="{'background-image':'url(' + newYouImage.image + ')'}"></div>

					<label>Select corresponding product (optional)</label>
					<p><select ng-options="product.id as product.name for product in products" ng-model="newYouImage.productId"></select></p>

					<div class="button success-bg" ng-click="saveYouImage()">Save</div> 
					<div class="button error-bg" ng-click="reset()">Cancel</div>
				</div>

			</div>

			<div class="admin-sub-section">

				<div class="grid-container">

					{{-- <div class="grid-square square" ng-repeat="youImage in youImages" ng-style="{'background-image':'url(' + youImage.image + ')'}"></div> --}}
					<div class="grid-square square" ng-repeat="youImage in youImages" back-img="@{{ youImage.image }}"></div>

					
					<div class="clear"></div>

				</div>
			</div>
			


		</div>

		<div class="admin-section" ng-show="showVideos" ng-cloak>
			<h2>Videos</h2>

		</div>

	</div>


@stop