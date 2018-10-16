import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

//firebase
import { AngularFireModule, FirebaseAppConfig } from 'angularfire2';
import { AngularFireDatabaseModule } from 'angularfire2/database';
import { AngularFireAuthModule } from 'angularfire2/auth';

import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { RouterModule, Routes } from '@angular/router';

//custom component
import { AppComponent } from './app.component';
import { BackendHomeComponent } from './backend/backend-home/backend-home.component';
import { RegisterUserComponent } from './authentification/register-user/register-user.component';
import { DashboardComponent } from './dashboard/dashboard.component';

//services
import { AuthService } from './authentification/services/auth.service';

const CONFIG: FirebaseAppConfig = {
  apiKey: "AIzaSyCMfUWvrSMgpSQm097Rtk_CNlZoqp8O_FQ",
  authDomain: "epitechdashboard.firebaseapp.com",
  databaseURL: "https://epitechdashboard.firebaseio.com",
  projectId: "epitechdashboard",
  storageBucket: "epitechdashboard.appspot.com",
  messagingSenderId: "983619226651"
};

const ROUTES: Routes = [
  { path: '', component: RegisterUserComponent, pathMatch: 'full'},
  { path: 'dashboard', component: DashboardComponent},
  { path: 'admin', component: BackendHomeComponent },
];

@NgModule({
  declarations: [
    AppComponent,
    BackendHomeComponent,
    RegisterUserComponent,
    DashboardComponent,
  ],
  imports: [
    BrowserModule,
    AngularFireModule.initializeApp(CONFIG),
    AngularFireDatabaseModule,
    FormsModule,
    ReactiveFormsModule,
    RouterModule.forRoot(ROUTES),
    AngularFireAuthModule
  ],
  providers: [
    AuthService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
