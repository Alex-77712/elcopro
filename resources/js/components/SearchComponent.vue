<template>
 <div class="container">
 	<div class="row">
 	   <div class="col-lg-12">
		 	<div class="md-form mt-4">
		 		<h1 class="text-center">Работа с api dadata.ru</h1>
			 		<div class="autocomplete">
				  		<input 
					  		class="form-control input-width" 
					  		type="text" 
					  		placeholder="Адрес, Банк, Предприятие" 
					  		aria-label="Search"
					  		v-model="param"
					  		@input="onChange"
				  		>
				  		<ul 
				  		 v-show="isOpen"
				  		 class="autocomplete-results"
				  		>
      						<li 
      							class="autocomplete-result"
      							v-for="(result, i) in results"
      							:key="i"
      							@click="setResult(result.value)"
      						>
      						  {{ result.value }}
      						</li>
    					</ul>
				  	</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-3 list-info">
			<h3>Адреса</h3>
			<ul>
				<li
					 v-for="(addressI, i) in addressInfo.suggestions"
					 @key="i"
				>
					{{addressI.value}}
				</li>
			</ul>
		</div>
		<div class="col-lg-3 list-info">
			<h3>Банк</h3>
			<ul>
				<li
					 v-for="(bankI, i) in bankInfo.suggestions"
					 @key="i"
				>
					{{bankI.value}}
				</li>
			</ul>
		</div>
		<div class="col-lg-3 list-info">
			<h3>Организация</h3>
			<ul>
				<li
					 v-for="(partyI, i) in partyInfo.suggestions"
					 @key="i"
				>
					{{partyI.value}}
				</li>
			</ul>
		</div>
	</div>
 </div>
</template>

<script>
	export default {
		data: () => ({
		   addressInfo: [],
		   bankInfo: [],
		   partyInfo: [],
		   posts:[],
		   param: '',
		   isOpen: false,
		   results: []
		}),

		methods: {
			onChange: function(event){
				axios.get('search',{params: {'s':event.target.value}})
				.then(response => {
					this.posts = response.data;
					this.addressInfo = JSON.parse(response.data[0].address_info);
					this.bankInfo = JSON.parse(response.data[1].bank_info);
					this.partyInfo = JSON.parse(response.data[2].party_info);
					this.isOpen = true;
					this.filterResults(this);
				});
			},
			filterResults: function(ctx) {
			 	this.results = this.addressInfo.suggestions.filter(function (item){
					 return item.value.toLowerCase().indexOf(ctx.param.toLowerCase() > -1);
				});
			},
			setResult: function(result) {
				this.param = result;
				this.isOpen = false;
				axios.post('change',{'data': this.posts});
			}
		}
    }
</script>

<style>

.input-width{
	width: 80%;
	margin: 40px 30px 0px 108px;
}

.list-info{
	margin: 100px 0px 0px 95px;
}

.autocomplete {
    position: relative;
 }

 .autocomplete-results {
    padding: 0;
    margin: 0;
    border: 1px solid #eeeeee;
    height: 120px;
    overflow: auto;
    margin-left: 107px;
    width: 80%;
 }

 .autocomplete-result {
    list-style: none;
    text-align: left;
    padding: 4px 2px;
    cursor: pointer;
 }

 .autocomplete-result:hover {
    background-color: #4AAE9B;
    color: white;
 }
</style>