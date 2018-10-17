import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpModule } from '@angular/http';

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
import { EmailVerificationComponent } from './authentification/email-verification/email-verification.component';
import { WheatherWidgetComponent } from './weather/wheather-widget/wheather-widget.component';
import { WheatherSettingComponent } from './weather/wheather-setting/wheather-setting.component';
import { WidgetComponent } from './widget/widget.component';


//services
import { AuthService } from './authentification/services/auth.service';
import { WheatherService } from './weather/wheather-service.service';

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
  { path: 'emailSection', component: EmailVerificationComponent},
  { path: 'widget', component: WidgetComponent},
  { path: 'weather', component: WheatherSettingComponent},
  { path: 'admin', component: BackendHomeComponent },
];

@NgModule({
  declarations: [
    AppComponent,
    BackendHomeComponent,
    RegisterUserComponent,
    DashboardComponent,
    EmailVerificationComponent,
    WheatherWidgetComponent,
    WheatherSettingComponent,
    WidgetComponent
  ],
  imports: [
    BrowserModule,
    AngularFireModule.initializeApp(CONFIG),
    AngularFireDatabaseModule,
    FormsModule,
    ReactiveFormsModule,
    RouterModule.forRoot(ROUTES),
    AngularFireAuthModule,
    HttpModule
  ],
  providers: [
    AuthService,
    WheatherService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
