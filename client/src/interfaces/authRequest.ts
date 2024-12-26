export interface RegisterRequest {
  email: string;
  password: string;
  username: string;
  password_confirmation: string;
}

export interface LoginRequest {
  email: string;
  password: string;
}
