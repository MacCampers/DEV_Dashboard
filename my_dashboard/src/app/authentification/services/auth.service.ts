import { Injectable } from '@angular/core';
import { AngularFireAuth } from 'angularfire2/auth';
import { AngularFireDatabase } from 'angularfire2/database';
import { Observable } from 'rxjs';
import * as firebase from 'firebase/app';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  user$: Observable<firebase.User>;
  
  constructor(private angularfireAuth: AngularFireAuth) {
    this.user$ = angularfireAuth.authState;
  }

  register(email: string, password: string) {
    return this.angularfireAuth.auth.createUserWithEmailAndPassword(email, password);
  }

  login(email: string, password: string) {
    return this.angularfireAuth.auth.signInWithEmailAndPassword(email, password);
  }

  updatePassword(email) {
  //  this.angularfireAuth.auth.sendPasswordResetEmail(email);
  }

  logout() {
    this.angularfireAuth.auth.signOut();
  }

  sendEmailVerification() {
    const user = firebase.auth().currentUser;
    if (user) {
      user.sendEmailVerification();
    }
  }
}
