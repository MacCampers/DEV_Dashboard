import { Injectable } from '@angular/core';
import { AngularFireAuth } from 'angularfire2/auth';
import { AngularFireDatabase } from 'angularfire2/database';
 

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor(private angularfireAuth: AngularFireAuth) { }

  register(email: string, password: string) {
    return this.angularfireAuth.auth.createUserWithEmailAndPassword(email, password);
  }

  login(email: string, password:string) {
    return this.angularfireAuth.auth.signInWithEmailAndPassword(email, password);
  }
}
