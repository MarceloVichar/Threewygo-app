type PaginationMetaType = {
    current_page?: number,
    from?: number,
    last_page?: number,
    per_page?: number,
    to?: number,
    total?: number,
}

export class PaginationMetaData {
  public current_page: number;
  public from: number;
  public last_page: number;
  public per_page: number;
  public to: number;
  public total: number;

  constructor(metaData: PaginationMetaType) {
    this.current_page = metaData.current_page || 0;
    this.from = metaData.from || 0;
    this.last_page = metaData.last_page || 0;
    this.per_page = metaData.per_page || 0;
    this.to = metaData.to || 0;
    this.total = metaData.total || 0;
  }
}
