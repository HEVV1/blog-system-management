export default interface Blog {
  id: number,
  title: string,
  description: string,
  status: string,
  createdAt: Date,
  user: {
    id: number,
    email: string,
    username: string,
  }
}
