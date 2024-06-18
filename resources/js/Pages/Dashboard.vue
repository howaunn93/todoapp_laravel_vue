<template>
  <Head title="Dashboard" />

	<AuthenticatedLayout>

		



		<v-app>
			<v-main>
				<v-theme-provider>
					<v-container>
						<v-row justify="center" class="ma-5">
							<v-col xs="12" sm="8">
								
								<v-card>
									<v-toolbar color="black darken-4" dark>
										<v-toolbar-title class="headline">To-do-list</v-toolbar-title>

										<v-spacer></v-spacer>

										<v-progress-circular
											v-if="loading"
											indeterminate model-value="20"
										></v-progress-circular>
									</v-toolbar>

									<v-list two-line subheader>
										<v-list-subheader class="headline">{{ day }}, {{ date }}{{ ord }} {{ year }}</v-list-subheader>
										<p class="mx-12 text-right"><b>{{ todos.length }}</b> Tasks</p>

										<v-list-item>

												<v-list-item-title>
													<v-text-field
														v-model="newTodo"
														label="Type your task"
														@keyup.enter="addTodo"
														persistent-hint
													/>
												</v-list-item-title>

										</v-list-item>
									</v-list>

									<v-list class="py-0 my-0">
										<v-list-subheader v-if="todos.length === 0">You have 0 Tasks, add some</v-list-subheader>
										<v-list-subheader v-else>Your Tasks</v-list-subheader>

											<v-list-item v-for="(todo, i) in todos" :key="i">


												
												<v-list-item class="py-0 my-0">
													<v-row class="align-center">
														<v-col cols="auto" class="py-0 my-0">
															<v-list-item-action>
																<v-checkbox v-model="activeTodos[i]" v-on:click="toggleTodo(i, todo.id, activeTodos[i])"></v-checkbox>
															</v-list-item-action>
														</v-col>
														<v-col>
															<v-list-item-title :class="{ done: activeTodos[i] }">{{ capitalize(todo.name) }}</v-list-item-title>
															<v-list-item-subtitle>Added on: {{ todo.created_at }}</v-list-item-subtitle>
														</v-col>
														<v-col cols="auto">
															<v-btn rounded color="red" v-if="activeTodos[i]" @click="removeTodo(i, todo.id)">
																<v-icon class="white--text">mdi-close</v-icon>
															</v-btn>
														</v-col>
													</v-row>
												</v-list-item>



											</v-list-item>

									</v-list>
								</v-card>
							</v-col>
						</v-row>
					</v-container>
				</v-theme-provider>
			</v-main>
		</v-app>


		<v-dialog v-model="dialogVisible" max-width="500">
			<template v-slot:default>
				<v-card>
					<v-card-title>
						Error
						<v-spacer></v-spacer>
					</v-card-title>
					<v-card-text>{{ dialogMessage }}</v-card-text>
					<v-card-actions>
						<v-btn text @click="dialogVisible = false">
							Close
						</v-btn>
					</v-card-actions>
				</v-card>
			</template>
		</v-dialog>



			
	</AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';

const dialogVisible = ref(false);
const dialogMessage = ref("");

const loading = ref(false);
const newTodo = ref('');
const todos = ref([]);
const activeTodos = ref([]);
const isTodoExist = ref(false);

const addTodo = async () => {
	loading.value = true;
  isTodoExist.value = false;
  const value = newTodo.value && newTodo.value.trim();
  if (!value) {
		loading.value = false;
    return;
  }
	const body = {
		name: newTodo.value,
	}
	await axios.post("http://localhost:8000/insert", body)
							.then(response=>{
								if(response.status===200 && response.data.success){
									todos.value.unshift({
										name: newTodo.value,
										created_at: formatDate(new Date()),
									});
									loading.value = false;
								}else{
									dialogVisible.value = true;
									dialogMessage.value = response.data.message;
								}
							})
							.catch(err=>{
								dialogVisible.value = true;
								dialogMessage.value = "Server Error";
								console.log("API Error: ", err);
							});
	activeTodos.value.unshift(false);
	newTodo.value = '';
}

const toggleTodo = async (index, id, expired) => {
	loading.value = true;
	const body = {
		id: id,
		expired: expired,
	};
	await axios.post("http://localhost:8000/update", body)
							.then(response=>{
								if(response.status===200 && response.data.success){
									activeTodos.value[index] = !expired;
									loading.value = false;
								}else{
									dialogVisible.value = true;
									dialogMessage.value = response.data.message;
								}
							})
							.catch(err=>{
								dialogVisible.value = true;
								dialogMessage.value = "Server Error";
								console.log("API Error: ", err);
							});
}

const removeTodo = async (index, id) => {
	loading.value = true;
	await axios.post("http://localhost:8000/delete", {id: id})
							.then(response=>{
								if(response.status===200 && response.data.success){
									todos.value.splice(index, 1);
									activeTodos.value.splice(index, 1);
									loading.value = false;
								}else{
									dialogVisible.value = true;
									dialogMessage.value = response.data.message;
								}
							})
							.catch(err=>{
								dialogVisible.value = true;
								dialogMessage.value = "Server Error";
								console.log("API Error: ", err);
							});
}

const fetchData = async () => {
	loading.value = true;
	await axios.post("http://localhost:8000/read",{})
							.then(response=>{
								if(response.status===200 && response.data.success){
									const res = response.data;
									todos.value = res.data.map((item,index)=>{
										if(item.expired_at!==null){
											activeTodos.value[index] = true;
										}
										return {
											id: item.id,
											name: item.name,
											created_at: formatDate(item.created_at),
											updated_at: item.updated_at,
											expired_at: item.expired_at,
											deleted_at: item.created_at,
										};
									});
									console.log(response);
									loading.value = false;
								}else{
									dialogVisible.value = true;
									dialogMessage.value = response.data.message;
								}
							})
							.catch(err=>{
								console.log("API Error: ", err);
							});
}



const capitalize = (value) => {
  if (!value) return '';
  value = value.toString();
  return value.charAt(0).toUpperCase() + value.slice(1);
}

const day = ref(todoDay());
const date = ref(new Date().getDate());
const ord = ref(nth(date.value));
const year = ref(new Date().getFullYear());

function todoDay() {
  const d = new Date();
  const days = [
    'Sunday', 'Monday', 'Tuesday', 'Wednesday',
    'Thursday', 'Friday', 'Saturday'
  ];
  return days[d.getDay()];
}

function nth(d) {
  if (d > 3 && d < 21) return 'th';
  switch (d % 10) {
    case 1: return 'st';
    case 2: return 'nd';
    case 3: return 'rd';
    default: return 'th';
  }
}

function formatDate(inputDate){
	return new Date(inputDate).toLocaleString('en-US', {
		year: 'numeric', month: '2-digit', day: '2-digit', hour: 'numeric', minute: '2-digit', hour12: true
	}).replace(',', '').replace(/(\d+)\/(\d+)\/(\d+),/, '$3-$1-$2');
}

onMounted(()=>{
	fetchData();
});

</script>

<style>
.done {
  text-decoration: line-through;
}
</style>
