<?php
include 'header.php';
?>
            <!-- Main Content -->
            <main id="main-content" class="admin-main">
                <div class="container-fluid p-4 p-lg-4">
                    
                    <!-- Page Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4 mb-lg-4 mb-xl-5">
                        <div>
                            <h1 class="h3 mb-0">Category Management</h1>
                            <p class="text-muted mb-0">Manage categories and their properties</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="addcategory.php" class="btn btn-outline-primary">
                                <i class="bi bi-plus-lg me-1"></i>
                                Add Category
                            </a>
                        </div>
                    </div>

                    <!-- Users Management Container -->
                    <div x-data="userTable">
                        
                      



                        <!-- Users Table -->
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h2 class="h5 card-title mb-0">Category Directory</h2>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-flex gap-2">
                                            <!-- Search -->
                                            <div class="position-relative">
                                                <input type="search" class="form-control form-control-sm" placeholder="Search users..." x-model="searchQuery" @input="filterUsers()" style="width: 200px;">
                                                <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-2 text-muted"></i>
                                            </div>
                                            
                                            <!-- Status Filter -->
                                            <select class="form-select form-select-sm" x-model="statusFilter" @change="filterUsers()" style="width: 150px;">
                                                <option value="">All Status</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                                <option value="pending">Pending</option>
                                            </select>
                                            
                                            <!-- Role Filter -->
                                            <select class="form-select form-select-sm" x-model="roleFilter" @change="filterUsers()" style="width: 150px;">
                                                <option value="">All Roles</option>
                                                <option value="admin">Admin</option>
                                                <option value="user">User</option>
                                                <option value="moderator">Moderator</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <!-- Bulk Actions Bar -->
                                <div class="bulk-actions-bar p-3 bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25" x-show="selectedUsers.length > 0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                            <span class="fw-medium text-primary">
                                                <span x-text="selectedUsers.length"></span> user<span x-show="selectedUsers.length !== 1">s</span> selected
                                            </span>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-success" @click="bulkAction('activate')">
                                                <i class="bi bi-check-circle me-1"></i>Activate
                                            </button>
                                            <button class="btn btn-sm btn-warning" @click="bulkAction('deactivate')">
                                                <i class="bi bi-x-circle me-1"></i>Deactivate
                                            </button>
                                            <button class="btn btn-sm btn-danger" @click="bulkAction('delete')">
                                                <i class="bi bi-trash me-1"></i>Delete
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center justify-content-center px-2" @click="selectedUsers = []" title="Clear selection">
                                                <i class="bi bi-x-lg" style="margin-left: 7px"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Table -->
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 40px;">
                                                    <input type="checkbox" class="user-select-checkbox" @change="toggleAll($event.target.checked)" :checked="selectedUsers.length === filteredUsers.length && filteredUsers.length > 0">
                                                </th>
                                                <th scope="col" role="button" tabindex="0" @click="sortBy('name')" @keydown.enter.prevent="sortBy('name')" @keydown.space.prevent="sortBy('name')" :aria-sort="sortField === 'name' ? (sortDirection === 'asc' ? 'ascending' : 'descending') : 'none'" class="sortable">
                                                    Name
                                                    <i class="bi bi-arrow-up" x-show="sortField === 'name' && sortDirection === 'asc'" aria-hidden="true"></i>
                                                    <i class="bi bi-arrow-down" x-show="sortField === 'name' && sortDirection === 'desc'" aria-hidden="true"></i>
                                                </th>
                                                <th scope="col" role="button" tabindex="0" @click="sortBy('email')" @keydown.enter.prevent="sortBy('email')" @keydown.space.prevent="sortBy('email')" :aria-sort="sortField === 'email' ? (sortDirection === 'asc' ? 'ascending' : 'descending') : 'none'" class="sortable">
                                                    Email
                                                    <i class="bi bi-arrow-up" x-show="sortField === 'email' && sortDirection === 'asc'" aria-hidden="true"></i>
                                                    <i class="bi bi-arrow-down" x-show="sortField === 'email' && sortDirection === 'desc'" aria-hidden="true"></i>
                                                </th>
                                                <th scope="col">Role</th>
                                                <th scope="col">Status</th>
                                                <th scope="col" role="button" tabindex="0" @click="sortBy('lastActive')" @keydown.enter.prevent="sortBy('lastActive')" @keydown.space.prevent="sortBy('lastActive')" :aria-sort="sortField === 'lastActive' ? (sortDirection === 'asc' ? 'ascending' : 'descending') : 'none'" class="sortable">
                                                    Last Active
                                                    <i class="bi bi-arrow-up" x-show="sortField === 'lastActive' && sortDirection === 'asc'" aria-hidden="true"></i>
                                                    <i class="bi bi-arrow-down" x-show="sortField === 'lastActive' && sortDirection === 'desc'" aria-hidden="true"></i>
                                                </th>
                                                <th style="width: 120px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="user in paginatedUsers" :key="user.id">
                                                <tr :class="{ 'selected': selectedUsers.includes(user.id) }">
                                                    <td>
                                                        <input type="checkbox" class="user-select-checkbox" :value="user.id" :checked="selectedUsers.includes(user.id)" @change="toggleUser(user.id)">
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img :src="user.avatar" class="rounded-circle me-2" width="32" height="32" :alt="user.name" loading="lazy" decoding="async">
                                                            <div>
                                                                <div class="fw-medium" x-text="user.name"></div>
                                                                <small class="text-muted" x-text="'ID: ' + user.id"></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td x-text="user.email"></td>
                                                    <td>
                                                        <span class="badge" :class="{
                                                                  'bg-danger': user.role === 'admin',
                                                                  'bg-primary': user.role === 'user', 
                                                                  'bg-warning': user.role === 'moderator'
                                                              }" x-text="user.role"></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge" :class="{
                                                                  'bg-success': user.status === 'active',
                                                                  'bg-secondary': user.status === 'inactive',
                                                                  'bg-warning': user.status === 'pending'
                                                              }" x-text="user.status"></span>
                                                    </td>
                                                    <td x-text="user.lastActive"></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                                <i class="bi bi-three-dots"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item" href="#" @click="editUser(user)">
                                                                    <i class="bi bi-pencil me-2"></i>Edit
                                                                </a></li>
                                                                <li><a class="dropdown-item" href="#" @click="viewUser(user)">
                                                                    <i class="bi bi-eye me-2"></i>View Profile
                                                                </a></li>
                                                                <li><hr class="dropdown-divider"></li>
                                                                <li><a class="dropdown-item text-danger" href="#" @click="deleteUser(user)">
                                                                    <i class="bi bi-trash me-2"></i>Delete
                                                                </a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-between align-items-center p-3">
                                    <div class="text-muted">
                                        Showing <span x-text="(currentPage - 1) * itemsPerPage + 1"></span> to 
                                        <span x-text="Math.min(currentPage * itemsPerPage, filteredUsers.length)"></span> of 
                                        <span x-text="filteredUsers.length"></span> results
                                    </div>
                                    <nav>
                                        <ul class="pagination pagination-sm mb-0">
                                            <li class="page-item" :class="{ 'disabled': currentPage === 1 }">
                                                <a class="page-link" href="#" @click.prevent="goToPage(currentPage - 1)">Previous</a>
                                            </li>
                                            <template x-for="page in visiblePages" :key="page">
                                                <li class="page-item" :class="{ 'active': page === currentPage }">
                                                    <a class="page-link" href="#" @click.prevent="goToPage(page)" x-text="page"></a>
                                                </li>
                                            </template>
                                            <li class="page-item" :class="{ 'disabled': currentPage === totalPages }">
                                                <a class="page-link" href="#" @click.prevent="goToPage(currentPage + 1)">Next</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        
                    </div> <!-- End Users Management Container -->

                </div>
            </main>

   

   <?php
include 'header.php';
?>
            <!-- Main Content -->
            <main id="main-content" class="admin-main">
                <div class="container-fluid p-4 p-lg-4">
                    
                    <!-- Page Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4 mb-lg-4 mb-xl-5">
                        <div>
                            <h1 class="h3 mb-0">User Management</h1>
                            <p class="text-muted mb-0">Manage users, roles, and permissions</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="bi bi-upload me-2"></i>Import Users
                            </button>
                            <button type="button" class="btn btn-outline-secondary" @click="exportUsers()">
                                <i class="bi bi-download me-2"></i>Export
                            </button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">
                                <i class="bi bi-person-plus me-2"></i>Add User
                            </button>
                        </div>
                    </div>

                    <!-- Users Management Container -->
                    <div x-data="userTable">
                        
                       

                       
                            <!-- System Alerts & Quick Actions -->
                            <div class="col-lg-6">
                                <div class="row g-4 g-lg-4 h-100">
                                    <!-- System Alerts -->
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h2 class="h5 card-title mb-0">System Alerts</h2>
                                                <span class="badge bg-danger rounded-pill" x-text="systemAlerts.length"></span>
                                            </div>
                                            <div class="card-body p-0">
                                                <template x-for="alert in systemAlerts.slice(0, 3)" :key="alert.id">
                                                    <div class="alert mb-0 border-0 border-start-0 rounded-0" :class="`alert-${alert.type}`">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <div>
                                                                <h6 class="alert-heading mb-1" x-text="alert.title"></h6>
                                                                <p class="mb-0 small" x-text="alert.message"></p>
                                                            </div>
                                                            <small class="text-muted" x-text="alert.time"></small>
                                                        </div>
                                                    </div>
                                                </template>
                                                <template x-if="systemAlerts.length === 0">
                                                    <div class="text-center p-4 text-muted">
                                                        <i class="bi bi-check-circle-fill text-success fs-1"></i>
                                                        <p class="mb-0 mt-2">All systems operational</p>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Quick Actions -->
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h2 class="h5 card-title mb-0">Quick Actions</h2>
                                            </div>
                                            <div class="card-body p-3 p-lg-4">
                                                <div class="row g-2 g-lg-3">
                                                    <div class="col-6">
                                                        <button class="btn btn-outline-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#userModal">
                                                            <i class="bi bi-person-plus me-1"></i>
                                                            Add User
                                                        </button>
                                                    </div>
                                                    <div class="col-6">
                                                        <button class="btn btn-outline-info btn-sm w-100" data-bs-toggle="modal" data-bs-target="#importModal">
                                                            <i class="bi bi-upload me-1"></i>
                                                            Import
                                                        </button>
                                                    </div>
                                                    <div class="col-6">
                                                        <button class="btn btn-outline-success btn-sm w-100" @click="exportUsers()">
                                                            <i class="bi bi-download me-1"></i>
                                                            Export
                                                        </button>
                                                    </div>
                                                    <div class="col-6">
                                                        <button class="btn btn-outline-warning btn-sm w-100" @click="sendBulkInvites()">
                                                            <i class="bi bi-envelope me-1"></i>
                                                            Invites
                                                        </button>
                                                    </div>
                                                    <div class="col-12">
                                                        <button class="btn btn-outline-secondary btn-sm w-100" @click="generateReport()">
                                                            <i class="bi bi-file-earmark-text me-1"></i>
                                                            Generate Report
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Users Table -->
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h2 class="h5 card-title mb-0">Users Directory</h2>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-flex gap-2">
                                            <!-- Search -->
                                            <div class="position-relative">
                                                <input type="search" class="form-control form-control-sm" placeholder="Search users..." x-model="searchQuery" @input="filterUsers()" style="width: 200px;">
                                                <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-2 text-muted"></i>
                                            </div>
                                            
                                            <!-- Status Filter -->
                                            <select class="form-select form-select-sm" x-model="statusFilter" @change="filterUsers()" style="width: 150px;">
                                                <option value="">All Status</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                                <option value="pending">Pending</option>
                                            </select>
                                            
                                            <!-- Role Filter -->
                                            <select class="form-select form-select-sm" x-model="roleFilter" @change="filterUsers()" style="width: 150px;">
                                                <option value="">All Roles</option>
                                                <option value="admin">Admin</option>
                                                <option value="user">User</option>
                                                <option value="moderator">Moderator</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <!-- Bulk Actions Bar -->
                                <div class="bulk-actions-bar p-3 bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25" x-show="selectedUsers.length > 0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                            <span class="fw-medium text-primary">
                                                <span x-text="selectedUsers.length"></span> user<span x-show="selectedUsers.length !== 1">s</span> selected
                                            </span>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-success" @click="bulkAction('activate')">
                                                <i class="bi bi-check-circle me-1"></i>Activate
                                            </button>
                                            <button class="btn btn-sm btn-warning" @click="bulkAction('deactivate')">
                                                <i class="bi bi-x-circle me-1"></i>Deactivate
                                            </button>
                                            <button class="btn btn-sm btn-danger" @click="bulkAction('delete')">
                                                <i class="bi bi-trash me-1"></i>Delete
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center justify-content-center px-2" @click="selectedUsers = []" title="Clear selection">
                                                <i class="bi bi-x-lg" style="margin-left: 7px"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Table -->
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 40px;">
                                                    <input type="checkbox" class="user-select-checkbox" @change="toggleAll($event.target.checked)" :checked="selectedUsers.length === filteredUsers.length && filteredUsers.length > 0">
                                                </th>
                                                <th scope="col" role="button" tabindex="0" @click="sortBy('name')" @keydown.enter.prevent="sortBy('name')" @keydown.space.prevent="sortBy('name')" :aria-sort="sortField === 'name' ? (sortDirection === 'asc' ? 'ascending' : 'descending') : 'none'" class="sortable">
                                                    Name
                                                    <i class="bi bi-arrow-up" x-show="sortField === 'name' && sortDirection === 'asc'" aria-hidden="true"></i>
                                                    <i class="bi bi-arrow-down" x-show="sortField === 'name' && sortDirection === 'desc'" aria-hidden="true"></i>
                                                </th>
                                                <th scope="col" role="button" tabindex="0" @click="sortBy('email')" @keydown.enter.prevent="sortBy('email')" @keydown.space.prevent="sortBy('email')" :aria-sort="sortField === 'email' ? (sortDirection === 'asc' ? 'ascending' : 'descending') : 'none'" class="sortable">
                                                    Email
                                                    <i class="bi bi-arrow-up" x-show="sortField === 'email' && sortDirection === 'asc'" aria-hidden="true"></i>
                                                    <i class="bi bi-arrow-down" x-show="sortField === 'email' && sortDirection === 'desc'" aria-hidden="true"></i>
                                                </th>
                                                <th scope="col">Role</th>
                                                <th scope="col">Status</th>
                                                <th scope="col" role="button" tabindex="0" @click="sortBy('lastActive')" @keydown.enter.prevent="sortBy('lastActive')" @keydown.space.prevent="sortBy('lastActive')" :aria-sort="sortField === 'lastActive' ? (sortDirection === 'asc' ? 'ascending' : 'descending') : 'none'" class="sortable">
                                                    Last Active
                                                    <i class="bi bi-arrow-up" x-show="sortField === 'lastActive' && sortDirection === 'asc'" aria-hidden="true"></i>
                                                    <i class="bi bi-arrow-down" x-show="sortField === 'lastActive' && sortDirection === 'desc'" aria-hidden="true"></i>
                                                </th>
                                                <th style="width: 120px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="user in paginatedUsers" :key="user.id">
                                                <tr :class="{ 'selected': selectedUsers.includes(user.id) }">
                                                    <td>
                                                        <input type="checkbox" class="user-select-checkbox" :value="user.id" :checked="selectedUsers.includes(user.id)" @change="toggleUser(user.id)">
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img :src="user.avatar" class="rounded-circle me-2" width="32" height="32" :alt="user.name" loading="lazy" decoding="async">
                                                            <div>
                                                                <div class="fw-medium" x-text="user.name"></div>
                                                                <small class="text-muted" x-text="'ID: ' + user.id"></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td x-text="user.email"></td>
                                                    <td>
                                                        <span class="badge" :class="{
                                                                  'bg-danger': user.role === 'admin',
                                                                  'bg-primary': user.role === 'user', 
                                                                  'bg-warning': user.role === 'moderator'
                                                              }" x-text="user.role"></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge" :class="{
                                                                  'bg-success': user.status === 'active',
                                                                  'bg-secondary': user.status === 'inactive',
                                                                  'bg-warning': user.status === 'pending'
                                                              }" x-text="user.status"></span>
                                                    </td>
                                                    <td x-text="user.lastActive"></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                                <i class="bi bi-three-dots"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item" href="#" @click="editUser(user)">
                                                                    <i class="bi bi-pencil me-2"></i>Edit
                                                                </a></li>
                                                                <li><a class="dropdown-item" href="#" @click="viewUser(user)">
                                                                    <i class="bi bi-eye me-2"></i>View Profile
                                                                </a></li>
                                                                <li><hr class="dropdown-divider"></li>
                                                                <li><a class="dropdown-item text-danger" href="#" @click="deleteUser(user)">
                                                                    <i class="bi bi-trash me-2"></i>Delete
                                                                </a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-between align-items-center p-3">
                                    <div class="text-muted">
                                        Showing <span x-text="(currentPage - 1) * itemsPerPage + 1"></span> to 
                                        <span x-text="Math.min(currentPage * itemsPerPage, filteredUsers.length)"></span> of 
                                        <span x-text="filteredUsers.length"></span> results
                                    </div>
                                    <nav>
                                        <ul class="pagination pagination-sm mb-0">
                                            <li class="page-item" :class="{ 'disabled': currentPage === 1 }">
                                                <a class="page-link" href="#" @click.prevent="goToPage(currentPage - 1)">Previous</a>
                                            </li>
                                            <template x-for="page in visiblePages" :key="page">
                                                <li class="page-item" :class="{ 'active': page === currentPage }">
                                                    <a class="page-link" href="#" @click.prevent="goToPage(page)" x-text="page"></a>
                                                </li>
                                            </template>
                                            <li class="page-item" :class="{ 'disabled': currentPage === totalPages }">
                                                <a class="page-link" href="#" @click.prevent="goToPage(currentPage + 1)">Next</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        
                    </div> <!-- End Users Management Container -->

                </div>
            </main>

            
    <!-- User Modal (Add/Edit) -->
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" method="POST" >
                    <form x-data="userForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Category Name</label>
                                <input type="text" class="form-control" x-model="form.firstName" required="">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" x-model="form.lastName" required="">
                            </div>
                         
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" >Save Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
 

    <!-- Page-specific Component -->

    <!-- Main App Script -->

<script defer="" src="../../beacon.min.js/v4513226cdae34746b4dedf0b4dfa099e1781791509496-1" integrity="sha512-ZE9pZaUXND66v380QUtch/5sE9tPFh2zg45pR2PB0CVkCtOREv2AJKkSidISWkysEuQ0EH8faUU5du78bx87UQ==" data-cf-beacon='{"version":"2024.11.0","token":"cd0b4b3a733644fc843ef0b185f98241","server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
</body>
</head></html> 
