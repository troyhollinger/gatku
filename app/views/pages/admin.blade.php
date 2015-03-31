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
		</div>

		<div class="admin-section" ng-show="showProducts" ng-cloak>
			
			<div class="admin-sub-section">

				<div class="button success-bg" ng-hide="editState" ng-click="editState = true">Create Product</div>
				<div class="button success-bg" ng-show="editState && editingNew" ng-click="createProduct();">Save</div>
								<div class="button success-bg" ng-show="editState && editingNew === false" ng-click="updateProduct();">Update</div>
				<div class="button error-bg" ng-show="editState" ng-click="clearNewProduct();">Cancel</div>
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

					<label>Price</label>
					<input type="number" ng-model="newProduct.price">

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

				<div class="button success-bg" ng-show="editState && editingNew" ng-click="createProduct();">Save</div>
				<div class="button success-bg" ng-show="editState && editingNew === false" ng-click="updateProduct();">Update</div>
				<div class="button error-bg" ng-show="editState" ng-click="clearNewProduct();">Cancel</div>
				<span ng-show="editState" class="edit-indicator">Editing Product</span>

			</div>

			<div class="admin-sub-section">

				<h2>Products</h2>

				<table class="admin-products-table">
					<tr ng-repeat="product in products">
						<td class="bold uppercase">@{{ product.name }}</td>
						<td class="faded">@{{ product.type.name }}</td>
						<td>
							<div class="button info-bg">View</div>
							<div class="button info-bg" ng-click="editProduct(product)">Edit</div>
							<div class="button error-bg">Delete</div>
						</td>
					</tr>
				</table>

			</div>

		</div>

		<div class="admin-section" ng-show="showYou" ng-cloak>
			<h2>You</h2>
		</div>

		<div class="admin-section" ng-show="showVideos" ng-cloak>
			<h2>Videos</h2>
		</div>

	</div>


@stop